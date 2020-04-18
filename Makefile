.PHONY : all release clean get-fonts

get-fonts :
	curl -sL https://api.github.com/repos/rsms/Inter/releases/latest | grep "browser_download_url.*zip" | cut -d : -f 2,3 | tr -d \" | xargs -n1 curl -sL -o Inter.zip
	curl -sL https://api.github.com/repos/JetBrains/JetBrainsMono/releases/latest | grep "browser_download_url.*zip" | cut -d : -f 2,3 | tr -d \" | xargs -n1 curl -sL -o JetBrains.zip
