export function menuTabs(type_user){
    if(type_user.some(userType => userType.id_type_user === 1) && !type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: 'Tus Repartos', href: './delivery'},
            {name: 'Explorar', href: './explore'},
            {name: 'Favoritos', href: './favorite'},
            {name: 'Perfil', href: './profile'}
        ]
    } else if(type_user.some(userType => userType.id_type_user === 2) && !type_user.some(userType => userType.id_type_user === 1)){
        return [
            {name: 'Repartos', href: './managedelivery'},
            {name: 'Tus Menus', href: './menu'},
            {name: 'Perfil', href: './profile'}
        ]
    } else if (type_user.some(userType => userType.id_type_user === 1) && type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: 'Repartos (Rider)', href: './delivery'},
            {name: 'Explorar', href: './explore'},
            {name: 'Favoritos', href: './favorite'},
            {name: 'Repartos (Provider)', href: './managedelivery'},
            {name: 'Tus Menus', href: './menu'},
            {name: 'Perfil', href: './profile'}
        ]
    }
}

export function menuTabsTwicePoints(type_user){
    if(type_user.some(userType => userType.id_type_user === 1) && !type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: 'Tus Repartos', href: '../delivery'},
            {name: 'Explorar', href: '../explore'},
            {name: 'Favoritos', href: '../favorite'},
            {name: 'Perfil', href: '../profile'}
        ]
    } else if(type_user.some(userType => userType.id_type_user === 2) && !type_user.some(userType => userType.id_type_user === 1)){
        return [
            {name: 'Repartos', href: '../managedelivery'},
            {name: 'Tus Menus', href: '../menu'},
            {name: 'Perfil', href: '../profile'}
        ]
    } else if (type_user.some(userType => userType.id_type_user === 1) && type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: 'Repartos (Rider)', href: '../delivery'},
            {name: 'Explorar', href: '../explore'},
            {name: 'Favoritos', href: '../favorite'},
            {name: 'Repartos (Provider)', href: '../managedelivery'},
            {name: 'Tus Menus', href: '../menu'},
            {name: 'Perfil', href: '../profile'}
        ]
    }
}