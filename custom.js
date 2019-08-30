function set_info() {
    //var value = document.add_lot.lot_img.value;
    document.add_lot.info_path.value = "Файл изображения выбран";
    document.add_lot.info_path.className = "form__item--info";
}

function set_avatar() {
    var value = document.sign_up.avatar.value;
    var index = -1;
    var ind = -1;
    var str = "\\";
    do {
        index = value.indexOf(str, index + 1);
        if (index > 0) {
            ind = index;
        }
    } while (index > 0);
    var fname = "Файл аватара ";
    if (ind > 0) {
        fname += value.substr(ind + 1);
    }
    fname += " выбран";
    document.sign_up.info_path.value = fname;
    document.sign_up.info_path.className = "form__item--info";
}