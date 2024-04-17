
const 
    entranceAnimation = [
        {animationClassName: 'trim-path-animation', isDone: false},
        {animationClassName: 'show-bg-animation', isDone: false},
        {animationClassName: 'open-curtain', isDone: false}],
    devInfo = [
        {devIndex: '0', fullname: 'Javier Díaz', workDescription: 'Design & Front-End Development', imgClassNanme: 'who-img-javi', contactURL: 'https://www.linkedin.com/in/javier-d%C3%ADaz-neira-120385153/'},
        {devIndex: '1', fullname: 'Mario Molina', workDescription: 'Full-Stack Developer', imgClassNanme: 'who-img-mario', contactURL: 'https://www.linkedin.com/in/mario-molina-ballesteros-a45a14277/'},
        {devIndex: '2', fullname: 'Pol Crespo', workDescription: 'Back-End Developer', imgClassNanme: 'who-img-pol', contactURL: 'https://www.linkedin.com/in/pol-crespo-hernandez-816a52204/'},
        {devIndex: '3', fullname: 'Josue Quispe', workDescription: 'Front-End Developer', imgClassNanme: 'who-img-josue', contactURL: 'https://www.linkedin.com/in/josue-quispe-mottoccanchi-791772285/'}],

    chatBotIconClassName = {active: 'fa-paper-plane', disabled: 'fa-circle-stop'},
    lowPassFilter = (newValue, prevValue, alpha) => alpha * newValue + (1 - alpha) * prevValue,
    updateMouseMove = e => [cursorX, cursorY] = [e.clientX, e.clientY];

let cursorX, cursorY, rollBarTransaltePerc, cursorRollBarTransaltePerc, currentMaskSize, 
maskSizeIsHovering, cursorHoveringContactMe, rollbarIsInViewPort, scrollDownIconisInViewPort
const percRoleTransition = 9;
let videoAnimationIsActive, videoCurrentTimeTarget;
const 
initialMapBoxPosition = { container: 'mapbox-map', style: 'mapbox://styles/mapbox/light-v11', center: [2.15899, 41.38879], zoom: 11, pitch: 30, bearing: 0 },
mapBoxToken = 'pk.eyJ1Ijoic3RyZWV0ZmVlZCIsImEiOiJjbHRkOWMzMXgwMDlyMmpybnA0MGt1N3RpIn0.jBsWG7vIB54CaqmpwbMapw';
let  mapboxMap, movingMapFrame, movingMapFrameDiference, searchBoxTimeoutID, modalConfirmatedCenter;
const maxWaitingTime = 2000;
let chatIsResponding, timeOutID;

document.addEventListener('DOMContentLoaded',   () => {
    initVariables();
    initVariablesAnimations();
    createAnimations();
    createAnimatonActivators();
    sendConsoleLogMessage();
    setEntranceAnimation();
    document.querySelector('.entrance-isotype').addEventListener('transitionend', setEntranceAnimation);
    document.querySelector('.entrance-curtine').addEventListener('transitionend', landingPageIn);
    document.addEventListener('mousemove', updateMouseMove);
    document.addEventListener('scroll', updateScrollBar);
    Array.from(document.querySelectorAll('.cursor-hoverable')).forEach(element => [{event: 'mouseenter', isHovering: true}, {event: 'mouseleave', isHovering: false}].forEach(obj => element.addEventListener(obj.event, () => document.querySelector('.cursor-frame').classList.toggle('cursor-hover', obj.isHovering))));
    Array.from(document.querySelectorAll('.mask-activator')).forEach(element => [{event: 'mouseenter', isHovering: true}, {event: 'mouseleave', isHovering: false}].forEach(obj => element.addEventListener(obj.event, () => maskedContainerActivator(obj.isHovering))));
    Array.from(document.querySelectorAll('.who-dev-name-container')).forEach(element => element.addEventListener('click', e => {!e.currentTarget.classList.contains('dev-shown') && changeDeveloperInfo(e)}));
    Array.from(document.querySelectorAll('.faq-question-aswer-container')).forEach(question => question.addEventListener('click', openFaqQuestion));
    Array.from(document.querySelectorAll('.movile-nav-landing-part-container')).forEach(element => element.addEventListener('click', () => document.querySelector('.navbar-frame').classList.remove('movile-nav-shown')));
    [{event: 'mouseenter', isHovering: true}, {event: 'mouseleave', isHovering: false}].forEach(obj => document.querySelector('.who-img-frame').addEventListener(obj.event, () => contactmeCursorActivator(obj.isHovering)));
    document.querySelector('.faq-option-faq').addEventListener('click', () => document.querySelector('.faq-content-container').classList.remove('chatbot-active'))
    document.querySelector('.nav-toggler-btn').addEventListener('click', toggleMovileNavContainer);
    document.querySelector('.faq-option-chatbot-container').addEventListener('click', openChatBotFrame);
    initMapbox();
    Array.from(document.querySelectorAll('.search-box-suggestion-container')).forEach(element => element.addEventListener('click', e => insertCoordinatesInMap(e.currentTarget, e.currentTarget.dataset.lng, e.currentTarget.dataset.lat)));
    ['.map-handle-container', '.interactive-map-frame'].forEach(classname => ['mousedown', 'touchstart'].forEach(event => document.querySelector(classname).addEventListener(event, setInteractiveMapFrameMovement, {passive: true})));
    ['.search-box-input-user', '.search-geolocalitation-btn', '.search-box-suggestions-container', '.mapbox-map-container', '.confirm-marker-btn', '.modal-backdrop', '.modal-frame'].forEach(classname => ['mousedown', 'touchstart', 'click'].forEach(event => document.querySelector(classname).addEventListener(event, e => e.stopPropagation(), {passive: true})))
    document.querySelector('.place-marker-btn').addEventListener('click', saveMarker)
    document.querySelector('.num-homeless-input').addEventListener('input', controlInputNumHomeless)
    document.querySelector('.search-box-input-user').addEventListener('input', requestMapboxSuggestions);
    document.querySelector('.confirm-marker-btn').addEventListener('click', confirmMarkerLocation)
    document.querySelector('.modal-backdrop').addEventListener('click', () => toggleModal(false))
    document.querySelector('.marker-map-frame').addEventListener('click', () => toggleMap({mapActive: false}));
    document.querySelector('.interactive-map-frame').addEventListener('click', e => e.stopPropagation());
    document.querySelector('.marker-map-icon-btn').addEventListener('click', e => toggleMap({e: e, mapActive: true}));
    document.querySelector('.search-geolocalitation-btn').addEventListener('click', getGeolocationCoords)
    mapboxMap.on('dragstart', mapboxMapDragStartHandler)
    mapboxMap.on('moveend', mapboxMapMoveEndHandler);
    mapboxMap.on('pitch', mapboxMapPitchHandler);
    mapboxMap.on('zoom', mapboxMapZoomntHandler);
    initChatBot()
    document.querySelector('.chatbot-text-input').addEventListener('input', chatbotInputController)
    document.querySelector('.chatbot-text-input').addEventListener('keydown', sendMessageController)
    document.querySelector('.chatbot-send-message').addEventListener('click', sendMessageController)
});


function contactmeCursorActivator(isActive){
    document.querySelector('.cursor-frame').classList.toggle('cursor-hovering-contact-me', isActive)
    if (isActive){
        cursorHoveringContactMe = true;
        moveCursorRollbar();
    } else {
        document.querySelector('.contact-me-cursor').addEventListener('transitionend', () => cursorHoveringContactMe = false, {once: true})
    }
}

function maskedContainerActivator(isActive){
    if (isActive){
        maskSizeIsHovering = true;
        resizeMaskSize();
    } else {
         maskSizeIsHovering = false;
    }
}


async function getDataNumbersfromDB() {
    return Promise.all([
        getDataDelivirys(),
        getDataProviders()])
        .then(data => {
            const [deliveries, providers] =  data;
            document.getElementById('data-providers').dataset.objectiveNumber = providers;
            document.getElementById('data-kg-food').dataset.objectiveNumber = (deliveries * 0.33).toFixed(0);
            document.getElementById('data-deliverys').dataset.objectiveNumber = deliveries;
            Array.from(document.querySelectorAll('.data-container')).forEach(element => element.classList.contains('data-container-shown') && showDataNumbersAnimation(element.querySelector('.data-number')))
        })
        .catch(error => {
            document.querySelector('.data-number-frame').classList.add('error-fetching')
            console.warn(`Failed to Fetch into DB: ${error}`);
        });
}

function getDataDelivirys() {
    return new Promise ((resolve, reject) => {
        setTimeout(() => {
            fetch('api/delivery/getTotalDeliveries')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    resolve(data.deliveries);
                })
                .catch(error => reject(error));
        }, 20)
    });
}

function getDataProviders() {
    return new Promise ((resolve, reject) => {
        setTimeout(() => {
            fetch('api/users/getUsersNums')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    resolve(data.providers);
                })
                .catch(error => reject(error));
        }, 20)
    });
}


function openChatBotFrame(){
    document.querySelector('.faq-content-container').classList.add('chatbot-active');
    document.querySelector('.question-shown')?.classList.remove('question-shown');
}

function initVariables(){
    cursorX = cursorY = rollBarTransaltePerc = cursorRollBarTransaltePerc = movingMapFrameDiference = 0;
    currentMaskSize = Number(window.getComputedStyle(document.querySelector('.masked-container')).getPropertyValue('mask-size').replace(/\D/g, ''));
    maskSizeIsHovering = movingMapFrame = cursorHoveringContactMe = rollbarIsInViewPort = scrollDownIconisInViewPort = false;
    moveCursor();
    moveScrollDownIcon();
    getDataNumbersfromDB();
}

function setEntranceAnimation(){
    document.body.classList.add('scroll-block');
    const nextAnimation = entranceAnimation.find(animation => !animation.isDone);
    if (nextAnimation){
        nextAnimation.isDone = true;
        document.querySelector('.entrance-scene').classList.add(nextAnimation.animationClassName);
    }
}

function landingPageIn(){
    document.body.classList.remove('scroll-block')
    document.querySelector('.entrance-scene').remove();

    //  ...
}

function toggleMovileNavContainer(){
    const navBarFrame = document.querySelector('.navbar-frame');
    const containerIsShown = navBarFrame.classList.contains('movile-nav-shown');
    navBarFrame.classList.toggle('movile-nav-shown', !containerIsShown);
    document.body.classList.toggle('scroll-block', !containerIsShown)

    //  ...
}

function moveCursor(){
    const cursor = document.querySelector('.cursor');
    const contactMeCursor = document.querySelector('.contact-me-cursor');
    const maskedContainer = document.querySelector('.masked-container')
    const cursorRect = cursor.getBoundingClientRect()
    const maskedContainerRect = maskedContainer.getBoundingClientRect();
    const newCursorX = lowPassFilter(cursorX, cursorRect.left, 0.5)
    const newCursorY = lowPassFilter(cursorY, cursorRect.top, 0.5)
    cursor.style.top = contactMeCursor.style.top = `${newCursorY}px`
    cursor.style.left = contactMeCursor.style.left = `${newCursorX}px`
    maskedContainer.style.maskPosition = `${newCursorX - maskedContainerRect.left - (currentMaskSize / 2)}px ${newCursorY - maskedContainerRect.top - (currentMaskSize / 2)}px`;
    requestAnimationFrame(moveCursor)
}

function moveRollBar(){
    rollBarTransaltePerc = (rollBarTransaltePerc - 0.1) % 100
    Array.from(document.querySelectorAll('.rollbar-item-container')).map(rollbarItem => rollbarItem.style.transform = `translateX(${rollBarTransaltePerc}%)`);
    rollbarIsInViewPort && requestAnimationFrame(moveRollBar)
}

function moveCursorRollbar(){
    cursorRollBarTransaltePerc = (cursorRollBarTransaltePerc - 0.2) % 100
    Array.from(document.querySelectorAll('.contact-me-rollbar-container')).map(rollbarItem => rollbarItem.style.transform = `translateX(${cursorRollBarTransaltePerc}%)`)
    cursorHoveringContactMe && requestAnimationFrame(moveCursorRollbar)
}

function moveScrollDownIcon(){
    const outerCircle = document.querySelector('.scroll-down-outer-circle');
    const innerCircle = document.querySelector('.scroll-down-inner-circle');
    const innerCircleRect = innerCircle.getBoundingClientRect();
    const outerCircleRect = outerCircle.getBoundingClientRect();
    const cursorRect = document.querySelector('.cursor').getBoundingClientRect();
    const ratioOuter = 0.015;
    const ratioInner = 0.02;
    outerCircle.style.transform = `translate(${(-outerCircleRect.width / 2) + ((cursorRect.left - outerCircleRect.left) * ratioOuter)}px, ${(-outerCircleRect.height / 2) + ((cursorRect.top - outerCircleRect.top) * ratioOuter)}px)`;
    innerCircle.style.transform = `translate(${(-innerCircleRect.width / 2) + ((cursorRect.left - innerCircleRect.left) * ratioInner)}px, ${(-innerCircleRect.width / 2) + ((cursorRect.top - innerCircleRect.top) * ratioInner)}px)`;
    scrollDownIconisInViewPort && requestAnimationFrame(moveScrollDownIcon)
}

function updateScrollBar() {
    document.querySelector('.scrollbar-thumb').style.top = `${(window.scrollY / (document.body.getBoundingClientRect().height - window.innerHeight)) * 100}%`
}

function openFaqQuestion(e){
    const currentCuestion = document.querySelector('.question-shown');
    currentCuestion != e.currentTarget && currentCuestion?.classList.remove('question-shown')
    e.currentTarget.classList.toggle('question-shown');
}

function resizeMaskSize(){
    const maskedContainer = document.querySelector('.masked-container');
    const grownSize = 250;
    const normalSize = 0;
    currentMaskSize = lowPassFilter(maskSizeIsHovering ? grownSize : normalSize, currentMaskSize, 0.15);
    document.querySelector('.cursor').style.opacity = maskSizeIsHovering ? 0: 1;
    maskedContainer.style.maskSize = `${currentMaskSize}px`
    currentMaskSize > 0.1 ? requestAnimationFrame(resizeMaskSize) : maskedContainer.style.maskSize = normalSize;
}

function changeDeveloperInfo(e){
    const chosenDevInfo = devInfo.find(info => info.devIndex == e.currentTarget.dataset.devIndex)
    document.querySelector('.dev-shown')?.classList.remove('dev-shown');
    document.querySelector('.dev-img-shown')?.classList.remove('dev-img-shown')
    e.currentTarget.classList.add('dev-shown');
    document.querySelector(`.${chosenDevInfo.imgClassNanme}`).classList.add('dev-img-shown');
    document.querySelector('.who-img-frame').href = chosenDevInfo.contactURL
    Array.from(document.querySelectorAll('.who-dev-info')).forEach(info => {
        info.classList.remove('changing-dev-info');
        info.classList.add('changing-dev-info');
        info.addEventListener('transitionend', () => {
            info.textContent = info.classList.contains('who-full-name') ? chosenDevInfo.fullname.toUpperCase() : chosenDevInfo.workDescription.toUpperCase();
            info.classList.remove('changing-dev-info');
        }); 
    });
}

function sendConsoleLogMessage(){
    const title = 'STREETFEED';
    const subtittle = 'Awesome! You\'ve discovered an easter egg!'
    const text = 'Your curiosity has brought you to a special place, We like you :) \nKeep nurturing that creative spark and you\'ll see how it can turn the ordinary into the extraordinary. Keep exploring and let your imagination guide you!'
    const titleStyle = [
        'font-size: 50px;',
        'font-weight: 900;',
        'font-family: sans-serif',        
    ].join(';');
    const subtittleStyle = [
        'font-size: 20px;',
        'font-weight: 600;',
        'font-family: sans-serif',        
    ].join(';')
    const textStyle = [
        'font-size: 13px;',
        'font-family: sans-serif',
    ].join(';')
    console.log(`\n%c${title}\n\n\n%c${subtittle}\n\n%c${text}\n\n\n`, titleStyle, subtittleStyle, textStyle)
}
function initVariablesAnimations(){
    videoCurrentTimeTarget = 0;
    videoAnimationIsActive = false;
}

function createAnimations(){
    navBarAnimation();
    lineMaskAnimation();
    roleExplainerAnimation();
    roleHigligthText();
    roleImagesMovement();
    roleTitleTextMovement();
    mapButtonHigthter();
    footerParalaxEffect();
    faqImageParallaxEffect();
}

function createAnimatonActivators(){
    callToActionLoadingController();
    showDataNumbersAnimationActivator();
    rollbarActivator();
    scrollDownActivator();
}

function navBarAnimation(){
    const infoAnimation = [
        { identifier: '.transparent-interface-needed', classToAdd: 'nav-transparent-mode', elements: [] },
        { identifier: '.dark-interface-needed', classToAdd: 'nav-dark-mode',  elements: [] } ]
    infoAnimation.forEach(info => info.elements = Array.from(document.querySelectorAll(info.identifier)))
    infoAnimation.forEach(info => {
        info.elements.forEach(element => {
            ScrollTrigger.create({
                trigger: `#${element.id}`,
                start: 'top 75px',
                end: 'bottom 75px',
                toggleClass: { targets: '.navbar-frame', className: info.classToAdd },
            });
        });
    });
}

function lineMaskAnimation(){
    const lineMasks = document.querySelectorAll('.line-mask')
    lineMasks.forEach(element => {
        gsap.to(`#${element.id}`, {
            scrollTrigger: {
                trigger: `#${element.id}`,
                start: 'top 65%',
                end: 'bottom 35%',
                scrub: 0.5
            },
            width: 0,
        });
    });
}


function roleExplainerAnimation(){
    gsap.to('.role-explainer-container-overflow', {
        scrollTrigger: {
            trigger: '.role-explainer-frame', 
            start: 'top 50%',
            end: 'top 0%',
            scrub: true, 
            onLeave: () => {
                gsap.to('.role-explainer-container-overflow', {
                    scrollTrigger: {
                        trigger: '.role-explainer-frame', 
                        start: 'bottom 100%',
                        end: 'bottom 50%',
                        scrub: true,
                    },
                    borderRadius: '30px',
                    height: '85vh',
                    width: '85vw'
                })
            }
        },
        borderRadius: '0px',
        height: '100vh',
        width: '100vw'
    });
};

function roleHigligthText(){
    const highlightTexts = document.querySelectorAll('.role-text-highlight');
    highlightTexts.forEach((element, i) => {
        const entranceStart = i * (100 / (highlightTexts.length + 1));
        const entranceLeave = entranceStart + percRoleTransition;
        const leaveStart = (i+1) * (100 / (highlightTexts.length + 1));
        const leaveLeave = (i+1) * (100 / (highlightTexts.length + 1)) + percRoleTransition;
        gsap.to(`#${element.id}`, {
            scrollTrigger: {
                trigger: '.role-explainer-frame',
                start: `${entranceStart}% top`,
                end: `${entranceLeave}% top`,
                scrub: true,
                onLeave: () => {
                    gsap.to(`#${element.id}`, {
                        scrollTrigger: {
                            trigger: '.role-explainer-frame',
                            start: `${leaveStart}% top`,
                            end: `${leaveLeave}% top`,
                            scrub: true,
                        },
                        color: 'gray'
                    });
                }
            },
            color: 'white'
        });
    });
}

function roleTitleTextMovement() {
    const names = document.querySelectorAll('.role-name');
    gsap.to('.role-name-container', {
        scrollTrigger: {
            trigger: '.role-explainer-frame',
            start: `${(100 / (names.length + 1))}% top`,
            end: `${(100 / (names.length + 1)) + percRoleTransition}% top`,
            scrub: true,
            onLeave: () => {
                gsap.to('.role-name-container', {
                    scrollTrigger: {
                        trigger: '.role-explainer-frame',
                        start: `${ 2 * (100 / (names.length + 1))}% top`,
                        end: `${ 2 * (100 / (names.length + 1)) + percRoleTransition}% top`,
                        scrub: true,
                    },
                    transform: `translateY(${-(100 / names.length) * 2}%)`
                });
            }
        },
        transform: `translateY(${-(100 / names.length) * 1}%)`
    });
}

function roleImagesMovement(){
    const images = document.querySelectorAll('.role-img-container');
    images.forEach((element, i) => {
            const entranceStart = i * (100 / (images.length + 1));
            const entranceLeave = entranceStart + percRoleTransition;            
            gsap.to(`#${element.id}`, {
                scrollTrigger: {
                    trigger: '.role-explainer-frame',
                    start: `${entranceStart}% top`,
                    end: `${entranceLeave}% top`,
                    scrub: 0.5,
                },
                top: 0,
                width: '100vw',
                height: '100vh',
            });
    });
}

function mapButtonHigthter(){
    const highlightTexts = document.querySelectorAll('.role-text-highlight');
    highlightTexts.forEach(_ => {
        const entranceStart = 2 * (100 / (highlightTexts.length + 1));
        const entranceLeave = entranceStart + percRoleTransition;
        const leaveStart = 3 * (100 / (highlightTexts.length + 1));
        const leaveLeave = 3 * (100 / (highlightTexts.length + 1)) + percRoleTransition;
        gsap.to('.marker-map-icon-hihglighter', {
            scrollTrigger: {
                trigger: '.role-explainer-frame',
                start: `${entranceStart}% top`,
                end: `${entranceLeave}% top`,
                scrub: true,
                onLeave: () => {
                    gsap.to('.marker-map-icon-hihglighter', {
                        scrollTrigger: {
                            trigger: '.role-explainer-frame',
                            start: `${leaveStart}% top`,
                            end: `${leaveLeave}% top`,
                            scrub: true,
                        },
                        opacity: 0
                    });
                }
            },
            opacity: 1
        });
    });
}

function faqImageParallaxEffect(){
    document.querySelector('.faq-img').addEventListener('load', () => {
        const imgRect = document.querySelector('.faq-img').getBoundingClientRect();
        const frameRect = document.querySelector('.faq-frame').getBoundingClientRect();
        gsap.to('.faq-img', {
            scrollTrigger: {
                trigger: '.faq-frame',
                start: 'top bottom',
                end: 'bottom top',
                scrub: true,
            },
            transform: `translateY(${imgRect.top - frameRect.top}px)`
        })
    }, {once: true})

}

// function callToActionAnimation(){
//     const isotypes = document.querySelectorAll('.call-to-action-isotype');
//     isotypes.forEach((element, i) => {
//         gsap.to(`#${element.id}`, {
//             scrollTrigger: {
//                 trigger: '.call-to-action-frame',
//                 start: `${50 - (i * (50 / isotypes.length))}% bottom`,
//                 end: '70% bottom',
//                 scrub: 2,
//             },
//             x: '-50%',
//             y: '-50%',
//             scale: 1 + (i * (1.5 / isotypes.length))
//         });
//     });
// }

function callToActionLoadingController(){
    const video = document.querySelector('.call-to-action-interactive-video');
    video.duration ? initializeInteractiveVideoLoaded() : video.addEventListener('loadedmetadata', initializeInteractiveVideoLoaded, {once: true})
}

function initializeInteractiveVideoLoaded(){
    callToActionAnimationActivator();
    callToActionAnimation();
}

function callToActionAnimationActivator(){
    ScrollTrigger.create({
        trigger: '.call-to-action-frame',
        start: 'top bottom',
        end: 'bottom top',
        onToggle: e =>  {
            videoAnimationIsActive = e.isActive;
            e.isActive && interactiveVideoMovement()
        }
    })
}

function callToActionAnimation(){
    const video = document.querySelector('.call-to-action-interactive-video');
    gsap.to('.call-to-action-interactive-video', {
        scrollTrigger: {
            trigger: '.call-to-action-frame',
            start: '15% bottom',
            end: '70% bottom',
            scrub: true,
            onUpdate: e => videoCurrentTimeTarget = video.duration * e.progress
        }
    });
    gsap.to(`.call-to-action-text-container`, {
        scrollTrigger: {
            trigger: '.call-to-action-frame',
            start: '55% 100%',
            end: '70% 80%',
            scrub: 2,
        },
        opacity: 1,
        scale: 1.5
    });
}

function footerParalaxEffect(){
    gsap.to('.footer', {
        scrollTrigger: {
            trigger: '.call-to-action-frame',
            start: 'bottom bottom',
            end: 'bottom top',
            scrub: true,
        },
        transform: 'translateY(0%)'
    });
}

function showDataNumbersAnimationActivator() {
    const numberContainers = document.querySelectorAll('.data-container');
    numberContainers.forEach(element => {
        ScrollTrigger.create({
            trigger: `#${element.id}`,
            start: 'top 95%',
            end: 'top 95%',
            once: true,
            toggleClass : 'data-container-shown',
            onEnter: () => showDataNumbersAnimation(element.querySelector('.data-number'))
        });
    });
}

function rollbarActivator(){
    ScrollTrigger.create({
        trigger: '.rollbar-container',
        start: 'top bottom',
        end: 'bottom top', 
        onToggle: e => {
            rollbarIsInViewPort = e.isActive;
            e.isActive && moveRollBar();
        }
    })
}

function scrollDownActivator(){
    ScrollTrigger.create({
        trigger: '.scroll-down-container ',
        start: 'top bottom',
        end: 'bottom top', 
        onToggle: e => {
            scrollDownIconisInViewPort = e.isActive;
            e.isActive && moveScrollDownIcon()
        }
    })
}

function showDataNumbersAnimation(number) {
    const durationMs = 1000 + ( Math.random() * 2500 );
    const changes = 150;
    const objectiveNumber = Number(number.dataset.objectiveNumber);
    let currentNumber = 0

    function changeNumber() {
        currentNumber += objectiveNumber / changes;
        number.textContent = Math.round(currentNumber);
        currentNumber < objectiveNumber ? setTimeout(changeNumber, durationMs / changes) : number.textContent = objectiveNumber;
    }
    changeNumber();

}

function interactiveVideoMovement(){
    const video = document.querySelector('.call-to-action-interactive-video');
    video.currentTime = lowPassFilter(videoCurrentTimeTarget, video.currentTime, 0.4);
    videoAnimationIsActive && video.addEventListener('canplay', interactiveVideoMovement, {once: true})
}

function initMapbox(){
    createMap();
    geolocationIsAvailable();
    mapboxMapPitchHandler()
    mapboxMapZoomntHandler();
}

function createMap(){
    mapboxgl.accessToken = mapBoxToken;
    mapboxMap = new mapboxgl.Map(initialMapBoxPosition)
}

function setInteractiveMapFrameMovement(e){
    const frame = document.querySelector('.interactive-map-frame');
    const backdrop = document.querySelector('.marker-map-frame')
    frame.style.transition = backdrop.style.transition = '0s';
    movingMapFrameDiference = ((e.type == 'mousedown' ? e.clientY : e.touches[0].clientY) - frame.getBoundingClientRect().top);
    document.addEventListener('mousemove', moveInteractiveMapFrame)
    document.addEventListener('touchmove', moveInteractiveMapFrame)
    document.addEventListener('mouseup', setFinalMovementInteractiveMap ,{once: true});
    document.addEventListener('touchend', setFinalMovementInteractiveMap ,{once: true})
}

function moveInteractiveMapFrame(e){
    const frame = document.querySelector('.interactive-map-frame');
    const backdrop = document.querySelector('.marker-map-frame')
    const frameRect = frame.getBoundingClientRect();
    frame.style.top = `${Math.max(((e.type == 'mousemove' ? e.clientY : e.touches[0].clientY) - movingMapFrameDiference), window.innerHeight * 0.15)}px`
    backdrop.style.backgroundColor = `rgba(0, 0 ,0, ${0.6 * (1 - (frameRect.top - (window.innerHeight * 0.15)) / (window.innerHeight - (window.innerHeight * 0.15)))})`
}

function setFinalMovementInteractiveMap() {
    const frame = document.querySelector('.interactive-map-frame');
    const backdrop = document.querySelector('.marker-map-frame')
    const frameRect = frame.getBoundingClientRect();
    toggleMap({mapActive: (frameRect.top < (window.innerHeight * 0.15 + frameRect.height * 0.25))})
    document.removeEventListener('mousemove', moveInteractiveMapFrame)
    document.removeEventListener('touchmove', moveInteractiveMapFrame)
    frame.removeAttribute('style');
    backdrop.removeAttribute('style');
}

function toggleMap({e = null , mapActive = false}){
    e?.stopPropagation();
    document.querySelector('.marker-map-frame').classList.toggle('map-active', mapActive)
    document.body.classList.toggle('scroll-block', mapActive)
    !mapActive && resetMapFrame();
}

function resetMapFrame(){
    document.querySelector('.interactive-map-frame').addEventListener('transitionend', () => {
        mapboxMap.jumpTo({center, zoom, pitch} = initialMapBoxPosition)
        document.querySelector('.search-box-option-selected')?.classList.remove('search-box-option-selected')
        document.querySelector('.search-box-input-user').value = '';
    }, {once: true})
}

function mapboxMapDragStartHandler(){
    document.querySelector('.search-box-option-selected')?.classList.remove('search-box-option-selected');
    document.querySelector('.map-pointer-item').style.transform = `translateY(${-90 * (Math.abs((mapboxMap.getPitch())  / 90))}px)`;
}

function mapboxMapPitchHandler(){
    const pitch = mapboxMap.getPitch();
    document.querySelector('.map-pointer').style.transform = `rotateX(${pitch}deg) translate(-50%, -50%)`
    document.querySelector('.map-pointer-top').style.transform = `translateY(${-20 * pitch / 90}px)`
    document.querySelector('.map-pointer-boder').style.transform = `rotateX(${Math.max(45, pitch)})`
}

function mapboxMapZoomntHandler(){
    const zoom = mapboxMap.getZoom()
    const pointerWidth = Math.max(0.1 , (15 * (zoom - 17)));
    document.querySelector('.map-pointer').style.width = `${pointerWidth}px`
    document.querySelector('.confirm-marker-btn').disabled = pointerWidth < 5
}

function mapboxMapMoveEndHandler(){
    document.querySelector('.map-pointer-item').removeAttribute('style')
}

function requestMapboxSuggestions(){
    clearTimeout(searchBoxTimeoutID);
    searchBoxTimeoutID = setTimeout(getMapboxSuggestionsId, 500)
}

function getMapboxSuggestionsId(){
    const suggestion = document.querySelector('.search-box-input-user').value.trim()
    if (suggestion != '') {
        const url = `https://api.mapbox.com/search/searchbox/v1/suggest?q=${suggestion.replace(' ', '+')}&language=es&limit=10&session_token=0b344167-ac1a-4431-88ec-d67bd7c0f942&access_token=${mapBoxToken}`;
        fetch(url)
        .then(response => response.json())
        .then(resultArr => {
            const suggestionsMapboxIds = resultArr.suggestions.map(suggestion => suggestion.mapbox_id);
            Promise.all(suggestionsMapboxIds.map(mapboxId => getMapboxInformationByID(mapboxId)))
            .then(results => insertSearchBoxRestults(results));
        })
        .catch(error => console.warn(`Mapbox Searchbox Error: ${error}`))
    }
}

async function getMapboxInformationByID(mapboxId){
    const url = `https://api.mapbox.com/search/details/v1/retrieve/${mapboxId}?access_token=${mapBoxToken}`
    return fetch(url)
    .then(response => response.json())
    .then(resultData => resultData)
    .catch(error => console.warn(`Get Data From Id: ${error}`))
}

function insertSearchBoxRestults(data){
    const frame = document.querySelector('.search-box-suggestions-container')
    Array.from(document.querySelectorAll('.search-box-suggestion-container')).forEach(suggestion => suggestion.remove());
    data.forEach(suggestionData => frame.appendChild(createSuggestion({
            name: suggestionData.properties.name, 
            city: suggestionData.properties.context.place?.name, 
            province: suggestionData.properties.context.region?.name, 
            country: suggestionData.properties.context.country?.name,
            lat: suggestionData.properties.coordinates.latitude,
            lng: suggestionData.properties.coordinates.longitude
        })))
}

function createSuggestion({name, city, province, country, lat, lng}) {
    const suggestionContainer = document.createElement('div');
    const nameDiv = document.createElement('div');
    const addressDiv = document.createElement('div');
    suggestionContainer.classList.add('search-box-suggestion-container', 'cursor-hoverable');
    suggestionContainer.dataset.lat = lat;
    suggestionContainer.dataset.lng = lng;
    nameDiv.classList.add('search-box-name');
    nameDiv.textContent = name;
    addressDiv.classList.add('search-box-address');
    addressDiv.textContent = [city, province, country].filter(data => data != null).join(', ');
    suggestionContainer.appendChild(nameDiv);
    suggestionContainer.appendChild(addressDiv);
    [{event: 'mouseenter', isHovering: true}, {event: 'mouseleave', isHovering: false}].forEach(obj => suggestionContainer.addEventListener(obj.event, () => document.querySelector('.cursor-frame').classList.toggle('cursor-hover', obj.isHovering)));
    suggestionContainer.addEventListener('click', e => insertCoordinatesInMap(suggestionContainer, lng, lat))
    return suggestionContainer;
}

function geolocationIsAvailable(){
    ('geolocation' in navigator) || document.querySelector('.search-geolocalitation-btn').classList.add('geolocation-not-available')
}

function getGeolocationCoords(e) {
    const target = e.currentTarget;
        navigator.geolocation.getCurrentPosition(
            position => insertCoordinatesInMap(target, position.coords.longitude, position.coords.latitude),
            error => {
                if (error.code === error.PERMISSION_DENIED || true) {
                    target.classList.add('geolocation-not-available')
                }
            },
            { enableHighAccuracy: true }
        );

}

function insertCoordinatesInMap(target, lng, lat){
    document.querySelector('.search-box-option-selected')?.classList.remove('search-box-option-selected')
    target.classList.add('search-box-option-selected')
    mapboxMap.flyTo({ center: [lng, lat], zoom: 19.5, speed: 1.8, curve: 1, essential: true, pitch: 25, bearing: 0});
}

function confirmMarkerLocation(){
    modalConfirmatedCenter = mapboxMap.getCenter();
    document.querySelector('.modal-location-latitude').textContent = modalConfirmatedCenter.lat;
    document.querySelector('.modal-location-longitude').textContent = modalConfirmatedCenter.lng;
    toggleModal(true);
}

function toggleModal(modalShown){
    document.querySelector('.modal-backdrop').classList.toggle('modal-shown', modalShown);
    document.querySelector('.place-marker-btn').disabled = true
    modalShown || (document.querySelector('.num-homeless-input').value = '');
}

function controlInputNumHomeless(e){
    const input = e.currentTarget;
    const oldValue = input.value;
    const newValue = (!/^[0-9]*$/.test(oldValue) || oldValue > 10 || oldValue.length == 1 && oldValue == 0) ? oldValue.slice(0, (oldValue.length - 1)) : oldValue;
    input.value = newValue;
    document.querySelector('.place-marker-btn').disabled = newValue == '';
}

function saveMarker(){
    const numPeople = Number(document.querySelector('.num-homeless-input').value);
    const url = '../endpoints/placeMarker.json';
    const markerInfo = {
        lng: modalConfirmatedCenter.lng,
        lat: modalConfirmatedCenter.lat,
        numPeople: numPeople
    }
    const requestOptions = {
        method: 'POST',
        body: JSON.stringify(markerInfo),
        headers: { 'Content-Type': 'application/json' }
    };

    // fetch(url, requestOptions)
    // .then(response => response.json())
    // .then(data => console.log(data))
    // .catch(error => console.warn(`Error Saving Marker: ${error}`))
    
    toggleModal(false)
    console.log(markerInfo)
    
}
function initChatBot(){
    chatbotInputController();
}

function chatbotInputController(){
    const input = document.querySelector('.chatbot-text-input');
    controlChatBotIcon({isValid: input.value.trim() !== '', isActive: chatIsResponding});
    textAreaHeightControl();
}

function textAreaHeightControl(){
    const input = document.querySelector('.chatbot-text-input');
    input.style.height = '0.1em';
    input.style.height = `${input.scrollHeight}px`;
}

function controlChatBotIcon({isValid = false, isActive = null}){
    const container = document.querySelector('.chatbot-send-message');
    const icon = document.querySelector('.chatbot-send-message-icon');
    chatIsResponding = isActive;

    container.classList.toggle('message-invalid', !isActive && !isValid);
    if (isActive !== null) {
        icon.classList.toggle('fa-paper-plane', !isActive);
        icon.classList.toggle('fa-circle-stop', isActive);
    }
}

function sendMessageController(e) {
    const input = document.querySelector('.chatbot-text-input');
    if (input.value !== '' && !chatIsResponding) {
        if (e.type === 'keydown' && e.key === 'Enter' && !e.shiftKey || e.type === 'click') {
            sendChatBotMessage(e);
        }
    } else if (e.type === 'click' && chatIsResponding) {
        const message = document.querySelector('.message-waiting-response');
        message.textContent = `${message.textContent.trimEnd()}...`
        setFinalChatbotConversation();
    }
}

function sendChatBotMessage(e){
    const frame = document.querySelector('.faq-chatbot-messages-frame');
    const input = document.querySelector('.chatbot-text-input');
    
    frame.appendChild(createUserMessage(input.value));
    frame.appendChild(createChatbotMessage());
    controlChatBotIcon({isValid: false, isActive: true});

    requestAiTimeOutController(input.value)
    .then(response => chatIsResponding && chatbotWritingAnimation(response) )
    .catch(error =>  chatIsResponding && createChatbotErrorMessage(error) );

    e.type == 'keydown' ? document.querySelector('.chatbot-text-input').addEventListener('input', resetInput, {once: true}) : resetInput()
}

function resetInput(){
    document.querySelector('.chatbot-text-input').value = ''
    textAreaHeightControl()
}

function createChatbotMessage(){
    const message = document.createElement('div');
    const chatbotText = document.createElement('span');
    const waitingIndicator = document.createElement('span');
    message.classList.add('faq-message', 'chatbot-message', 'message-waiting-response');
    chatbotText.classList.add('faq-chatbot-text');
    waitingIndicator.classList.add('chatbot-waiting-indicator');
    message.appendChild(chatbotText);
    message.appendChild(waitingIndicator)
    return message
}

function createUserMessage(userMessage){
    const message = document.createElement('div');
    message.classList.add('faq-message', 'user-message')
    message.textContent = userMessage.trim()
    return message
}

function createChatbotErrorMessage(errorMessage){
    const container = document.querySelector('.message-waiting-response');
    const textContianer = container.querySelector('.faq-chatbot-text')
    container.classList.add('error-message');
    textContianer.textContent = errorMessage;
    chatIsResponding && setFinalChatbotConversation();
}

function chatbotWritingAnimation(chatbotText) {
    const textSpan = document.querySelector('.message-waiting-response .faq-chatbot-text');
    let i = 0;

    function addCharacter() {
        if (chatIsResponding){
            if (i < chatbotText.length) {
                textSpan.textContent += chatbotText.charAt(i++);
                setTimeout(addCharacter, Math.round(Math.random()* 20 ));
            } else{
                setFinalChatbotConversation()
            }
        }
    }
    addCharacter();
}

function setFinalChatbotConversation(){
    const container = document.querySelector('.message-waiting-response');
    const input = document.querySelector('.chatbot-text-input');
    container.querySelector('.chatbot-waiting-indicator')?.remove();
    container.classList.remove('message-waiting-response');
    controlChatBotIcon({isValid: input.value.trim() !== '', isActive: false})
}

function requestAiTimeOutController(userMessage){
    return new Promise((resolve, reject) => {
        timeOutID = setTimeout(() => reject(new Error('The waiting time has been exceeded. Try again later')), maxWaitingTime)
        requestAIResponse(userMessage).
        then(response => {
            clearTimeout(timeOutID)
            resolve(response);
        })
        .catch(error => reject(error));
    });
}

function requestAIResponse(userMessage) {
    const url = '../endpoints/openAi.json'
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify(userMessage)
    }
    return new Promise((resolve, reject) => {
        setTimeout(()=> {
            fetch(url)
            .then(response => response.json())
            .then(data => resolve(data[0].text))
            .catch(_ => reject(new Error('An Error ocurred. Please, try again later')))
        }, Math.random() * maxWaitingTime * 1.5)
    });
}