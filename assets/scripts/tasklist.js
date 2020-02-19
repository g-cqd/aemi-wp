class Task {
    constructor( name, func, timeout = 0, tokens = 1 ) {
        this.name = name;
        this.func = func;
        this.value = null;
        this.tasklist = null;
        this.deps = [ ];
        this.timeout = timeout;
        this.unusedTokens = Array( tokens ).fill( 1 );
        this.tokens = tokens;
        this.usedTokens = [ ];
        this.timing = {};
    }
    setDependency( { task, name, tasklist, use = true } ) {
        if ( task ) { return this.deps.push( { task: task, use: use } ); } else if ( name ) {
            let task;
            if ( tasklist ) { task = tasklist.hasTask( name ) ? tasklist.getTask( name ) : null; }
            if ( !task ) {
                if ( window && window.tasklists ) {
                    for ( const tasklist of window.tasklists ) {
                        if ( tasklist.hasTask( name ) ) {
                            task = tasklist.getTask( name );
                            break;
                        }
                    }
                }
            }
            if ( task ) { return this.deps.push( { task: task, use: use } ); } else { return false; }
        }
    }
    pending( ) { return this.unusedTokens.length === this.tokens; }
    done( ) { return this.usedTokens.length === this.tokens; }
    running( ) { return !this.pending( ) && !this.done( ); }
    runnable( ) {
        for ( const { task }
            of this.deps )
            if ( task.done( ) === false ) return false;
        return true;
    }
    ready( ) { return this.runnable( ) && this.pending( ); }
    usable( ) { return this.runnable( ) && this.unusedTokens.length > 0; }
    init( ) {
        for ( const { task }
            of this.deps ) {
            window.addEventListener( task.name + 'Ended', ( ) => this.run( ), false );
        }
        if ( this.tasklist ) {
            window.addEventListener( 'tasklist' + this.tasklist.id + 'Started', ( ) => this.run( ), false );
            window.addEventListener( 'tasklist' + this.tasklist.id + 'Resumed', ( ) => this.run( ), false );
        }
    }
    delay( timeout = 0 ) {
        if ( timeout > 0 ) this.timeout = timeout;
        return timeout;
    }
    wait( timeout ) {
        timeout = timeout !== undefined && typeof timeout === 'number' && timeout > 0 ? timeout : this.timeout ? this.timeout : 0;
        return new Promise( r => setTimeout( r, timeout ) );
    }
    timer( ) {
        if ( this.timing.start === undefined ) {
            this.timing.start = window && window.performance && window.performance.now ? window.performance.now( ) : Date.now( );
            window.dispatchEvent( new Event( this.name + 'Started' ) );
            this.unusedTokens.pop( );
        } else if ( this.timing.end === undefined ) {
            this.timing.end = window && window.performance && window.performance.now ? window.performance.now( ) : Date.now( );
            this.timing.elapsed = this.timing.end - this.timing.start;
            this.usedTokens.push( 1 );
            window.dispatchEvent( new Event( this.name + 'Ended' ) );
        }
    }
    async run( ...args ) {
        if ( !this.ready( ) ) return false;
        let parameters = [ ];
        if ( args ) parameters = [ ...args ];
        else if ( this.deps.length > 0 )
            for ( const { task, use }
                of this.deps )
                if ( use ) parameters.push( task.value );
        try {
            if ( this.timeout ) await this.wait( );
            this.timer( );
            this.value = await this.func( ...parameters );
            this.timer( );
        } catch ( error ) { throw error.stack; }
        return this.value;
    }
}
class TaskList {
    constructor( options = {} ) {
        this.options = options;
        this.list = new Map( );
        this.queue = [ ];
        this.dones = [ ];
        if ( window ) {
            if ( window.tasklists ) window.tasklists.push( this );
            else window.tasklists = [ this ];
        }
        this.id = window.tasklists.length;
        this.timing = {};
    }
    get size( ) { return this.list.size; }
    get length( ) { return this.queue.length; }
    filled( ) { return this.size > 0; }
    pending( ) { return this.size === this.length; }
    running( ) { return this.filled( ) && this.size !== this.length && this.length > 0; }
    done( ) { return this.filled( ) && this.length === 0; }
    setTask( task, deps, timeout ) {
        if ( task instanceof Task ) {
            if ( !this.hasTask( task.name ) ) {
                task.tasklist = this;
                if ( deps instanceof Array )
                    for ( const dep of deps ) task.setDependency( dep );
                if ( timeout ) task.delay( tiemout );
                this.list.set( task.name, task );
                this.queue.push( task.name );
                return true;
            }
        }
        return false;
    }
    hasTask( string ) {
        return this.list.has( string );
    }
    getTask( string ) {
        return this.hasTask( string ) ? this.list.get( string ) : -1;
    }
    isTaskDone( string ) {
        return this.hasTask( string ) ? this.getTask( string ).done( ) : -1;
    }
    getNextTask( ) {
        return this.pending( ) || this.running( ) ? this.getTask( this.queue[ 0 ] ) : -1;
    }
    shift( ) {
        return this.queue.shift( );
    }
    push( task ) {
        return this.dones.push( task );
    }
    setTasks( ...tasks ) {
        for ( const [ task, deps, timeout ] of tasks ) {
            this.setTask( task, deps, timeout );
        }
    }
    timer( ) {
        if ( this.timing.start === undefined ) {
            this.timing.start = window && window.performance && window.performance.now ? window.performance.now( ) : Date.now( );
            window.dispatchEvent( new Event( 'taskList' + this.id + 'Started' ) );
        } else if ( this.timing.end === undefined ) {
            this.timing.end = window && window.performance && window.performance.now ? window.performance.now( ) : Date.now( );
            this.timing.elapsed = this.timing.end - this.timing.start;
            window.dispatchEvent( new Event( 'taskList' + this.id + 'Ended' ) );
        }
    }
    init( ) {
        window.addEventListener( 'taskEnded_' + this.id, ( ) => this.run( ), false );
        for ( const [ name, task ] of this.list ) task.init( );
    }
    start( ...args ) {
        if ( this.pending ) this.run( ...args );
        else return false;
    }
    startAll() {
        if ( this.pending ) for ( const name of this.queue ) this.runTask( name );
        else return false;
    }
    async run( ...args ) {
        if ( this.filled( ) ) {
            if ( this.pending( ) ) {
                this.timer( );
            } else if ( this.done( ) ) {
                this.timer( );
                return true;
            }
            let task = this.getNextTask( );
            if ( task.ready( ) ) {
                this.shift( );
                window.dispatchEvent( new Event( 'taskStarted_' + this.id ) );
                let value = await task.run( ...args );
                window.dispatchEvent( new Event( 'taskEnded_' + this.id ) );
                this.push( task.name );
                return value;
            }
            else {
                return -1;
            }
        }
    }
    async runTask( string, ...args ) {
        if ( this.hasTask( string ) ) {
            if ( this.filled() || !this.done() ) {
                if ( this.pending() ) this.timer();
                let task = this.getTask( string );
                if ( task.ready( ) ) {
                    let indexOf = this.queue.indexOf( task.name );
                    this.queue.splice( indexOf, 1 );
                    window.dispatchEvent( new Event( 'taskStarted_' + this.id ) );
                    let value = await task.run( ...args );
                    window.dispatchEvent( new Event( 'taskEnded_' + this.id ) );
                    this.push( task.name );
                    return value;
                }
            }
            else return -1;
        }
    }
}
