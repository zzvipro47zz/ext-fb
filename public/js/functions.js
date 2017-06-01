function random(type, len = 5) {
	if (type == 'email') {
		var characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		var charactersLength = characters.length - 1;
		var randomString = '';
		for (var i = 0; i < len; i++) {
			randomString += characters[random_int(0, charactersLength)];
		}
		return randomString;
	} else if (type == 'string') {
		var characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var charactersLength = characters.length - 1;
		var randomString = '';
		for (var i = 0; i < len; i++) {
			randomString += characters[random_int(0, charactersLength)];
		}
		return randomString;
	} else if (type == 'number') {
		var str = str_shuffle('0123456789');
		randomNumber = str.substr(0, len);
		return randomNumber;
	} else if (type == 'phone') {
		length = 7;
		var nhamang = ['+8486', '+8496', '+8497', '+8498', '+84162', '+84163', '+84164', '+84165', '+84166', '+84167', '+84168', '+84169', '+849+84', '+8493', '+8412+84', '+84121', '+84122', '+84126', '+84128', '+8491', '+8494', '+84123', '+84124', '+84125', '+84127', '+84129'];
		var randomNhamang = nhamang[random_int(0, nhamang.length - 1)];
		var phone = randomNhamang + str_shuffle('0123456789').substr(0, length);
		return phone;
	}
}

function str_shuffle(string) {
	var parts = string.split('');
	for (var i = parts.length; i > 0;) {
		var random = parseInt(Math.random() * i);
		var temp = parts[--i];
		parts[i] = parts[random];
		parts[random] = temp;
	}
	return parts.join('');
}

function stripUnicode(str) {
	if (!str) return false;
	str = str.toLowerCase();

	str = str.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
	str = str.replace(/đ/gi, 'd');
	str = str.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
	str = str.replace(/í|ì|ỉ|ĩ|ị/gi, 'i');
	str = str.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
	str = str.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
	str = str.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
	str = str.replace(/Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ/gi, 'A');
	str = str.replace(/Đ/gi, 'D');
	str = str.replace(/É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ/gi, 'E');
	str = str.replace(/Í|Ì|Ỉ|Ĩ|Ị/gi, 'I');
	str = str.replace(/Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ/gi, 'O');
	str = str.replace(/Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự/gi, 'U');
	str = str.replace(/Ý|Ỳ|Ỷ|Ỹ|Ỵ/gi, 'Y');
	str = str.replace(/ /gi, '');

	return str;
}

function random_int(min, max) {
	return Math.floor(Math.random() * (max - min + 1) + min);
}