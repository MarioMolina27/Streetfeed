import esTranslations from '../../lang/shared/nav/es.json';
import enTranslations from '../../lang/shared/nav/en.json';
import caTranslations from '../../lang/shared/nav/ca.json';

export function menuTabs(type_user, lang){
    let translations = translateFileSelect(lang);

    if(type_user.some(userType => userType.id_type_user === 1) && !type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: translations.youreDeliveriesTab, href: './delivery'},
            {name: translations.exploreTab, href: './explore'},
            {name: translations.favoritesTab, href: './favorite'},
            {name: translations.profileTab, href: './profile'}
        ]
    } else if(type_user.some(userType => userType.id_type_user === 2) && !type_user.some(userType => userType.id_type_user === 1)){
        return [
            {name: translations.deliveriesTab, href: './managedelivery'},
            {name: translations.youreMenusTab, href: './menu'},
            {name: translations.profileTab, href: './profile'}
        ]
    } else if (type_user.some(userType => userType.id_type_user === 1) && type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: translations.youreDeliveriesRiderTab, href: './delivery'},
            {name: translations.exploreTab, href: './explore'},
            {name: translations.favoritesTab, href: './favorite'},
            {name: translations.youreDeliveriesProviderTab, href: './managedelivery'},
            {name: translations.youreMenusTab, href: './menu'},
            {name: translations.profileTab, href: './profile'}
        ]
    }
}

export function menuTabsTwicePoints(type_user, lang){
    let translations = translateFileSelect(lang);

    if(type_user.some(userType => userType.id_type_user === 1) && !type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: translations.youreDeliveriesTab, href: '../delivery'},
            {name: translations.exploreTab, href: '../explore'},
            {name: translations.favoritesTab, href: '../favorite'},
            {name: translations.profileTab, href: '../profile'}
        ]
    } else if(type_user.some(userType => userType.id_type_user === 2) && !type_user.some(userType => userType.id_type_user === 1)){
        return [
            {name: translations.deliveriesTab, href: '../managedelivery'},
            {name: translations.youreMenusTab, href: '../menu'},
            {name: translations.profileTab, href: '../profile'}
        ]
    } else if (type_user.some(userType => userType.id_type_user === 1) && type_user.some(userType => userType.id_type_user === 2)){
        return [
            {name: translations.youreDeliveriesRiderTab, href: '../delivery'},
            {name: translations.exploreTab, href: '../explore'},
            {name: translations.favoritesTab, href: '../favorite'},
            {name: translations.youreDeliveriesProviderTab, href: '../managedelivery'},
            {name: translations.youreMenusTab, href: '../menu'},
            {name: translations.profileTab, href: '../profile'}
        ]
    }
}
function translateFileSelect(lang){
    let translations = {};
    if(lang === 'es'){
        translations = esTranslations;
    } else if(lang === 'en'){
        translations = enTranslations;
    }
    else if(lang === 'ca'){
        translations = caTranslations;
    }
    return translations;
}
export function getRouteActiveName(route) {
    let parts = route.split('/');
    let routeActive = parts[parts.length - 1];
    return routeActive;
}