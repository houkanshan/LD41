clean:
	rm -rf data

setup: clean
	mkdir data
	mkdir data/users
	echo 1 > data/global_id.txt
	chmod -R 0777 data
	sudo chown -R nobody:nobody data

resetup: clean setup
