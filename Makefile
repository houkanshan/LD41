clean:
	rm -rf data

setup: clean
	mkdir data
	mkdir data/users
	echo 1 > data/global_id.txt
	echo 0 > data/total_win.txt
	echo 0 > data/total.txt
	echo 0,0.0.0.2,0 > data/last_win.txt
	chmod -R 0777 data
	sudo chown -R nobody:nobody data

resetup: clean setup
