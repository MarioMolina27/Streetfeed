export function createMenu(menu) {
    const url = 'api/menu/create-menu';
    try {
        const data = {
            id_user: menu.user_id,
            title: menu.title,
            first_product: menu.first_product,
            second_product: menu.second_product,
            drink_product: menu.drink_product,
            active: menu.active
        };
        return axios.post(url, data);
    } catch (error) {
        console.log('Error:', error);
    }
}

export function updateMenu(menu) {
    const url = `api/menu/update-menu`;
    try {
        const data = {
            id_menu: menu.id_menu,
            title: menu.title,
            first_product: menu.first_product,
            second_product: menu.second_product,
            drink_product: menu.drink_product,
            active: menu.active
        };
        return axios.post(url, data);
    } catch (error) {
        console.log('Error:', error);
    }
}

export function deleteMenu(id) {
    const url = `api/menu/delete-menu/${id}`;
    try {
        return axios.post(url);
    } catch (error) {
        console.log('Error:', error);
    }
}

export function updateLaunchpacks(menu,numLaunchpacks) {
    const url = `api/menu/updateLaunchPack/${menu.id_menu}`;
    try {
        const data = {
            numLaunchpack: numLaunchpacks
        };
        return axios.post(url, data);
    } catch (error) {
        console.log('Error:', error);
    }
}