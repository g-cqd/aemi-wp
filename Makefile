.phony: all

SHELL=/bin/bash
DIR=${CURDIR}
SRC_DIR=$(DIR)/src
SRC_JS_DIR=$(SRC_DIR)/assets/js
SRC_CSS_DIR=$(SRC_DIR)/assets/css
BUILD_DIR=$(DIR)/dist
TARGET_DIR=$(BUILD_DIR)/aemi

setup: init clean minify release

all: clean minify release

init:
	@if [ command git &> /dev/null ]; then git submodule update --init --recursive; fi;
	@if [ command composer &> /dev/null ]; then composer update; fi; 
	@if [ command npm &> /dev/null ]; then cd $(SRC_JS_DIR) && npm install; fi;
	@if [ command npm &> /dev/null ]; then cd $(SRC_CSS_DIR) && npm install; fi;

release:
	@if [ ! -d $(BUILD_DIR) ]; then mkdir $(BUILD_DIR); fi;
	@if [ ! -d $(TARGET_DIR) ]; then mkdir $(TARGET_DIR); fi;
	@rsync --recursive "$(SRC_DIR)/" "$(TARGET_DIR)" --exclude "**/node_modules" --exclude "**/.git*" --exclude "**/package*.json" --exclude "**/.eslintrc.json" --exclude "assets/**/README.md" --exclude "**/ext/test" --exclude "**/sonar*" --exclude "**/Makefile" --exclude "**/.DS_Store" --exclude "**/composer**";
	@(cd "$(BUILD_DIR)" && zip -r "aemi.zip" "aemi" && rm -Rdf "aemi");


show:
	@echo $(DIR)
	@echo $(SRC_DIR)
	@echo $(SRC_CSS_DIR)
	@echo $(SRC_JS_DIR)
	@echo $(BUILD_DIR)
	@echo $(TARGET_DIR)

minify:
	@cd $(SRC_JS_DIR) && npm run pack
	@cd $(SRC_CSS_DIR) && make -B all

clean:
	@if [ -d $(BUILD_DIR) ]; then rm -Rfd $(BUILD_DIR); fi;

js-clean:
	@cd $(SRC_JS_DIR) && npm run clean

css-clean:
	@cd $(SRC_CSS_DIR) && make clean

mrproper:
	@if [ -d $(BUILD_DIR) ]; then rm -Rfd $(BUILD_DIR); fi;
	@cd $(SRC_JS_DIR) && npm run clean
	@cd $(SRC_CSS_DIR) && make clean
