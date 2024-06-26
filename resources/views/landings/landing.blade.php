@extends('layouts.layout-land')
       
@section('content')
<div class="cursor-frame">
    <div class="cursor"></div>
    <div class="contact-me-cursor">
        <div class="contact-me-rollbar-frame">
            <div class="contact-me-rollbar-container">
                <div class="contact-me-rollbar-item">{{ $trans->contact_me }}</div>
                <div class="contact-me-rollbar-separator">·</div>
                <div class="contact-me-rollbar-item">{{ $trans->contact_me }}</div>
                <div class="contact-me-rollbar-separator">·</div>
            </div>
            <div class="contact-me-rollbar-container">
                <div class="contact-me-rollbar-item">{{ $trans->contact_me }}</div>
                <div class="contact-me-rollbar-separator">·</div>
                <div class="contact-me-rollbar-item">{{ $trans->contact_me }}</div>
                <div class="contact-me-rollbar-separator">·</div>
            </div>
        </div>
    </div>
</div>
<div class="scrollbar-container">
    <div class="scrollbar-rail"></div>
    <div class="scrollbar-thumb"></div>
</div>
{{-- <div class="entrance-scene">
    <div class="entrance-curtine"></div>
    <div class="entrance-curtine"></div>
    <div class="entrance-curtine"></div>
    <div class="entrance-curtine"></div>
    <svg class="entrance-isotype"version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 595.3 682.6" xml:space="preserve">
        <path d="M171.9,477.8L297,613l125.2-135.2c-104.9-72.2-133.6-214.6-64.9-321.9c-39.1-13.2-81.4-13.2-120.5,0
            c68.4,106.9,40.2,248.8-64,321.3L171.9,477.8z M509.7,490.6c25.9,44,28.5,97.9,6.9,144.3c-12.2,26.2-41.1,40.5-69.4,34.3
            c-2-0.4-3.8-1.6-5.1-3.2c-3.1-3.9-2.5-9.6,1.4-12.7c42.5-34.1,52.9-94.5,24.3-140.8c-1.8-2.8-3.7-5.5-6-8L297,682.6l-164.8-178
            c-2.2,2.5-4.2,5.1-6,8c-28,45.2-18.8,104,21.5,138.5c1.6,1.4,2.6,3.2,3,5.2c0.9,4.9-2.4,9.6-7.3,10.5c-28.5,5.2-56.8-10-68.2-36.6
            c-19.9-46.4-15.9-99.7,10.7-142.6c4.4-7.2,9.7-13.8,15.8-19.7c-73.5-107.8-45.7-254.7,62.1-328.2c-34.6-36.8-77.4-64.9-125-82
            C18.2,50.3,3,32.4-1,10.7C-1.3,9.5-1.2,8.3-1,7.1c1.1-4.9,5.9-8,10.8-6.9c76.4,16.9,145.4,57.6,197,116.4
            c57.8-23.9,122.6-23.9,180.4,0c51.6-58.7,120.6-99.5,197-116.4c1.2-0.3,2.4-0.3,3.6,0c4.9,0.9,8.2,5.6,7.2,10.5
            c-4,21.7-19.3,39.6-40,47.1c-47.5,17.1-90.4,45.2-125,82c107.8,73.5,135.6,220.4,62.1,328.2C499,474.7,504.9,482.3,509.7,490.6z
            M452.9,441.5c58.9-86.2,36.7-203.7-49.4-262.5c-1.1-0.8-2.2-1.5-3.4-2.2c-58.8,86.1-36.7,203.7,49.4,262.5
            C450.7,440,451.8,440.7,452.9,441.5z M141,441.5c87.4-57,112-174,55-261.4c-0.7-1.1-1.5-2.3-2.2-3.4c-87.4,57-112,174-55,261.4
            C139.5,439.2,140.2,440.3,141,441.5z"/>
    </svg>
</div>   --}}
<div class="navbar-frame">
    <div class="navbar-container">
        <a class="abr-nav-logotype flex-center cursor-hoverable" href="#" translate="no">STFD</a>
        <div class="nav-options-container flex-center">
            <a class="nav-option-container nav-link-option cursor-hoverable nav-what" href="#what">
                <div class="option-overflow-window">
                    <div class="nav-option-name-container">
                        <div class="nav-option-name">{{ $trans->what }}</div>
                        <div class="nav-option-name">{{ $trans->what }}</div>
                    </div>
                </div>
            </a>
            <a class="nav-option-container nav-link-option cursor-hoverable nav-how" href="#how">
                <div class="option-overflow-window">
                    <div class="nav-option-name-container">
                        <div class="nav-option-name">{{ $trans->how }}</div>
                        <div class="nav-option-name">{{ $trans->how }}</div>
                    </div>
                </div>
            </a>
            <a class="nav-option-container nav-link-option cursor-hoverable nav-who" href="#who">
                <div class="option-overflow-window">
                    <div class="nav-option-name-container">
                        <div class="nav-option-name">{{ $trans->who }}</div>
                        <div class="nav-option-name">{{ $trans->who }}</div>
                    </div>
                </div>
            </a>
            <a class="nav-option-container nav-button-option nav-link-to-login cursor-hoverable go-to-login-btn">
                <div class="option-overflow-window">
                    <div class="nav-option-name-container">
                        <div class="nav-option-name">{{ $trans->start_helping }}</div>
                        <div class="nav-option-name">{{ $trans->start_helping }}</div>
                    </div>
                </div>
            </a>
        </div>
        <button class="nav-toggler-btn btn" type="button">
            <div class="nav-toggler-line nav-toggler-line-top simple-line"></div>
            <div class="nav-toggler-line nav-toggler-line-bottom simple-line"></div>
        </button>
        <div class="nav-bottom-line simple-line"></div>
    </div>
    <div class="movile-options-container-bg"></div>
    <div class="movile-options-container">
        <div class="movile-nav-content-container">
            <div class="movile-nav-landing-parts-frame">
                <a class="movile-nav-landing-part-container cursor-hoverable" href="#what">
                    <div class="movile-nav-langing-part-name">{{ $trans->what }}</div>
                    <div class="movile-nav-bottom-line simple-line"></div>
                </a>
                <a class="movile-nav-landing-part-container cursor-hoverable" href="#how">
                    <div class="movile-nav-langing-part-name">{{ $trans->how }}</div>
                    <div class="movile-nav-bottom-line simple-line"></div>
                </a>
                <a class="movile-nav-landing-part-container cursor-hoverable" href="#who">
                    <div class="movile-nav-langing-part-name">{{ $trans->who }}</div>
                    <div class="movile-nav-bottom-line simple-line"></div>
                </a>
            </div>
            <div class="movile-nav-link-to-app-frame">
                <div class="movile-nav-call-to-action">{{ $trans->make_dif }}</div>
                <a class="movile-nav-link-to-app-btn go-to-login-btn">
                    <div class="movile-nav-option-name-container">
                        <div class="movile-nav-option-name">{{ $trans->start_helping }}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class=lang-btn-container>
        <div class="lang-option lang-btn-es cursor-hoverable" data-current="{{$lang}}" data-lang="es">ES</div>
        <div class="lang-option lang-btn-en cursor-hoverable" data-current="{{$lang}}" data-lang="en">EN</div>
        <div class="lang-option lang-btn-ca cursor-hoverable" data-current="{{$lang}}" data-lang="ca">CA</div>
    </div>
</div>

</div>
<div class="header">
    <div class="header-text-container">
        <div class="header-title title-street" translate="no">STREET</div>
        <div class="header-title title-feed" translate="no">FEED</div>
        <div class="header-subtitle">{{ $trans->way_to_help }}</div>
        <div class="masked-container flex-center">
            <div class="header-subtitle masked-subtitle"> {{$trans->begin_with_us}}
                <div class="mask-activator"></div>
            </div>
        </div>
    </div>
    <svg class="header-isotype"version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 595.3 682.6" xml:space="preserve">
        <path d="M171.9,477.8L297,613l125.2-135.2c-104.9-72.2-133.6-214.6-64.9-321.9c-39.1-13.2-81.4-13.2-120.5,0
            c68.4,106.9,40.2,248.8-64,321.3L171.9,477.8z M509.7,490.6c25.9,44,28.5,97.9,6.9,144.3c-12.2,26.2-41.1,40.5-69.4,34.3
            c-2-0.4-3.8-1.6-5.1-3.2c-3.1-3.9-2.5-9.6,1.4-12.7c42.5-34.1,52.9-94.5,24.3-140.8c-1.8-2.8-3.7-5.5-6-8L297,682.6l-164.8-178
            c-2.2,2.5-4.2,5.1-6,8c-28,45.2-18.8,104,21.5,138.5c1.6,1.4,2.6,3.2,3,5.2c0.9,4.9-2.4,9.6-7.3,10.5c-28.5,5.2-56.8-10-68.2-36.6
            c-19.9-46.4-15.9-99.7,10.7-142.6c4.4-7.2,9.7-13.8,15.8-19.7c-73.5-107.8-45.7-254.7,62.1-328.2c-34.6-36.8-77.4-64.9-125-82
            C18.2,50.3,3,32.4-1,10.7C-1.3,9.5-1.2,8.3-1,7.1c1.1-4.9,5.9-8,10.8-6.9c76.4,16.9,145.4,57.6,197,116.4
            c57.8-23.9,122.6-23.9,180.4,0c51.6-58.7,120.6-99.5,197-116.4c1.2-0.3,2.4-0.3,3.6,0c4.9,0.9,8.2,5.6,7.2,10.5
            c-4,21.7-19.3,39.6-40,47.1c-47.5,17.1-90.4,45.2-125,82c107.8,73.5,135.6,220.4,62.1,328.2C499,474.7,504.9,482.3,509.7,490.6z
            M452.9,441.5c58.9-86.2,36.7-203.7-49.4-262.5c-1.1-0.8-2.2-1.5-3.4-2.2c-58.8,86.1-36.7,203.7,49.4,262.5
            C450.7,440,451.8,440.7,452.9,441.5z M141,441.5c87.4-57,112-174,55-261.4c-0.7-1.1-1.5-2.3-2.2-3.4c-87.4,57-112,174-55,261.4
            C139.5,439.2,140.2,440.3,141,441.5z"/>
    </svg>
    <a class="scroll-down-container cursor-hoverable" href="#what">
        <div class="scroll-down-circle scroll-down-outer-circle"></div>
        <div class="scroll-down-circle scroll-down-inner-circle flex-center">
            <svg class="scroll-down-arrow" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="20 7 60 80">
                <g transform="translate(0,-952.36218)">
                    <path d="M 49.8125 7 A 1.0001 1.0001 0 0 0 49.34375 7.25 L 22.34375 31.25 A 1.0001 1.0001 0 1 0 23.65625 32.75 L 49 10.21875 L 49 92 C 48.9925 92.5283 49.471635 93.03125 50 93.03125 C 50.528365 93.03125 51.007472 92.5283 51 92 L 51 10.21875 L 76.34375 32.75 A 1.0001 1.0001 0 1 0 77.65625 31.25 L 50.65625 7.25 A 1.0001 1.0001 0 0 0 49.8125 7 z " transform="translate(0,952.36218)"/>
                </g>
            </svg>
        </div>
    </a>
</div>
<div class="marker-map-frame">
    <div class="marker-map-container">
        <div class="marker-map-icon-hihglighter"></div>
        <div class="marker-map-icon-btn cursor-hoverable flex-center">
            <svg class="marker-map-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 96">
                <path d="M65.23,61.76c-2.65,12.35-9.61,21.16-17.77,21.16-10.45,0-18.93-14.44-18.93-32.26s8.48-32.26,18.93-32.26" />
                <path d="M47.46,44.78v38.14c14.05,0,26.03-8.73,30.67-20.99" />
                <line x1="16.86" y1="62.03" x2="78.05" y2="62.03" />
                <line x1="48.86" y1="39.28" x2="16.87" y2="39.28" />
                <path d="M65.25,13.08c-8.85,0-16.01,7.07-16.01,15.78s16.01,22.18,16.01,22.18c0,0,16.01-13.46,16.01-22.18s-7.16-15.78-16.01-15.78Zm0,23.62c-4.39,0-7.96-3.51-7.96-7.84s3.56-7.83,7.96-7.83,7.94,3.51,7.94,7.83-3.55,7.84-7.94,7.84Z" />
                <path d="M65.25,36.7c-4.39,0-7.96-3.51-7.96-7.84s3.56-7.83,7.96-7.83,7.94,3.51,7.94,7.83-3.55,7.84-7.94,7.84Z" />
                <path d="M80.18,50.66c0,17.82-14.66,32.26-32.72,32.26S14.74,68.48,14.74,50.66,29.39,18.4,47.46,18.4" />
            </svg>
        </div>
    </div>
    <div class="interactive-map-frame">
        <div class="interactive-map-content-frame">
            <div class="map-user-frame">
                <div class="search-box-input-user-container">
                    <input class="search-box-input-user" type="text" placeholder="{{$trans->write_location}}">
                </div>
                <div class="mapbox-map-container">
                    <div id="mapbox-map"></div>
                    <div class="map-pointer-container">
                        <svg class="map-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                            <circle class="map-pointer-shadow" cx="50" cy="50" r="50"></circle>
                            <g class="map-pointer-item">
                                <circle class="map-pointer-boder" cx="50" cy="50" r="50"></circle>
                                <g class="map-pointer-top">
                                    <circle class="map-pointer-inner-circle" cx="50" cy="50" r="50"></circle>
                                    <circle class="map-pointer-outter-circle" cx="50" cy="50" r="35"></circle>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
                <div class="map-markers-options-container">
                    <div class="search-geolocalitation-btn cursor-hoverable">
                        <svg class="search-geolocalitation-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                            <circle class="search-icon-stroke" cx="50" cy="50" r="50"></circle>
                            <circle class="search-icon-stroke" cx="50" cy="50" r="30"></circle>
                            <circle class="search-icon-fill" cx="50" cy="50" r="23"></circle>
                        </svg>
                        <div class="search-geolocalitation-text">
                            <div class="search-geolocalitation-primary-text">{{$trans->actual_ubi}}</div>
                            <div class="search-geolocalitation-secondary-text">{{$trans->error_margin_ubi}}</div>
                        </div>
                    </div>
                    <div class="search-box-suggestions-frame">
                        <div class="search-box-suggestion-title">{{$trans->suggestions}}</div>
                        <div class="search-box-suggestions-container">
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.353858016777" data-lng="2.06977688038913">
                                <div class="search-box-name">Carrer Del Cinema Bel 24</div>
                                <div class="search-box-address">Cornellà de Llobregat, Barcelona, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.329379" data-lng="2.093482">
                                <div class="search-box-name">Cinema Capri</div>
                                <div class="search-box-address">El Prat de Llobregat, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.295859" data-lng="2.00773">
                                <div class="search-box-name">Cinesa Cinema</div>
                                <div class="search-box-address">Gavà, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.465887946952" data-lng="2.00058944178967">
                                <div class="search-box-name">Carrer De La Cinemàtica 2</div>
                                <div class="search-box-address">Castellbisbal, Barcelona, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.398629" data-lng="2.120681">
                                <div class="search-box-name">Prodigius Cinema</div>
                                <div class="search-box-address">Barcelona, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.300546" data-lng="2.013032">
                                <div class="search-box-name">Franfur el Cinema</div>
                                <div class="search-box-address">Gavà, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.383803" data-lng="2.166797">
                                <div class="search-box-name">L'Alternativa Festival de Cinema Independent de Barcelona</div>
                                <div class="search-box-address">Barcelona, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.338308" data-lng="2.050251">
                                <div class="search-box-name">Southern Sun</div>
                                <div class="search-box-address">Sant Boi de Llobregat, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.39232" data-lng="2.16781">
                                <div class="search-box-name">La Cinemateca</div>
                                <div class="search-box-address">Barcelona, Spain</div>
                            </div>
                            <div class="search-box-suggestion-container cursor-hoverable" data-lat="41.381917" data-lng="2.044876">
                                <div class="search-box-name">Cinebaix</div>
                                <div class="search-box-address">Sant Feliu de Llobregat, Spain</div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="confirm-marker-btn nav-option-container nav-button-option cursor-hoverable" disabled>
                        <div class="option-overflow-window">
                            <div class="nav-option-name-container">
                                <div class="nav-option-name">{{$trans->confirm_location}}</div>
                                <div class="nav-option-name">{{$trans->confirm_location}}</div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="map-handle-container cursor-hoverable">
            <div class="map-handle"></div>
        </div>
    </div>
    <div class="modal-backdrop">
        <div class="modal-frame">
            <div class="modal-header">
                <div class="modal-title">{{$trans->almost_done}}</div>
                <div class="modal-subtitle">{{$trans->tell_us_num_people}}</div>
            </div>
            <div class="modal-content-container">
                <div class="modal-location-container">
                    <div class="modal-location-info">{{$trans->latitude}}<span class="modal-location-latitude"></span></div>
                    <div class="modal-location-info">{{$trans->longitude}}<span class="modal-location-longitude"></span></div>
                </div>
                <div class="modal-input-container">
                    <input class="num-homeless-input" type="text" inputmode="numeric" placeholder="{{$trans->num_of_people}}">
                    <button type="button" class="place-marker-btn nav-option-container nav-button-option cursor-hoverable" disabled>
                        <div class="option-overflow-window">
                            <div class="nav-option-name-container">
                                <div class="nav-option-name">{{$trans->place_marker}}</div>
                                <div class="nav-option-name">{{$trans->place_marker}}</div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>   
        </div>
    </div>
</div>
<div class="rollbar-container">
    <div class="rollbar-item-container flex-center">
        <div class="rollbar-text" translate="no">STREETFEED</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
        <div class="rollbar-text">{{$trans->start_helping}}</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
        <div class="rollbar-text" translate="no">STREETFEED</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
        <div class="rollbar-text">{{$trans->start_helping}}</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
    </div>
    <div class="rollbar-item-container flex-center">
        <div class="rollbar-text" translate="no">STREETFEED</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
        <div class="rollbar-text">{{$trans->start_helping}}</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
        <div class="rollbar-text" translate="no">STREETFEED</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
        <div class="rollbar-text">{{$trans->start_helping}}</div>
        <img class="rollbar-icon-separator" src="img/land/separator-icon.svg" alt="RollBar Separator Icon" draggable="false">
    </div>
</div>
<div id="what" class="separator-container separator-number-rigth separator-what">
    <div class="seprator-text separation-name">{{$trans->what}}</div>
    <div class="separator-line simple-line"></div>
    <div class="separation-number-container">
        <div class="seprator-text separation-number">01</div>
        <div class="separation-number-gradient"></div>
    </div>
</div>
<div class="explanatory-text-container flex-center">
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->in}}<span translate="no">STREETFEED</span>,</div>
        <div id="line-mask-0" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->we_have_got}}</div>
        <div id="line-mask-1" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->simple_reciple}}</div>
        <div id="line-mask-2" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->take_surplus_food}}</div>
        <div id="line-mask-3" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->sprinkle_in_some}}</div>
        <div id="line-mask-4" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->compasion_and}}</div>
        <div id="line-mask-5" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->serve_it_up_to_our}}</div>
        <div id="line-mask-6" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->homeless_friends}}</div>
        <div id="line-mask-7" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->who_could_use_a}}</div>
        <div id="line-mask-8" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->helping_hand}}</div>
        <div id="line-mask-9" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->it_is_more_tha_just}}</div>
        <div id="line-mask-10" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->meals}}</div>
        <div id="line-mask-11" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->it_is_about_building}}</div>
        <div id="line-mask-12" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->connections}}</div>
        <div id="line-mask-13" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->spreading_warmth}}</div>
        <div id="line-mask-13-2" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->so_pull_up_a_chair}}</div>
        <div id="line-mask-14" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->and_lets_start}}</div>
        <div id="line-mask-15" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->cooking_up_some}}</div>
        <div id="line-mask-16" class="line-mask"></div>
    </div>
    <div class="explanatory-line flex-center">
        <div class="explanatory-text">{{$trans->kidness}}</div>
        <div id="line-mask-17" class="line-mask"></div>
    </div>
</div>
<div id="role-explainer-frame" class="role-explainer-frame transparent-interface-needed">
    <div class="role-explainer-container-overflow">
        <div class="role-explainer-container">
            <div class="role-img-frame">
                <div id="role-img-rider" class="role-img-container flex-center">
                    <img class="role-img" src="img/land/rider-role-img.png" alt="Rider Role Photo" draggable="false">
                </div>
                <div id="role-img-provider" class="role-img-container flex-center">
                    <img class="role-img" src="img/land/provider-role-img.png" alt="Provider Role Photo" draggable="false">
                </div>
                <div id="role-img-mapping-helper" class="role-img-container flex-center">
                    <img class="role-img" src="img/land/mapping-helper-role-img.png" alt="Maping Helper Role Photo" draggable="false">
                </div>
            </div>
            <div class="role-name-frame-overflow">
                <div class="role-name-container">
                    <div id="role-name-rider" class="role-name">{{$trans->rider_prof}}</div>
                    <div id="role-name-provider" class="role-name">{{$trans->provider_prof}}</div>
                    <div id="role-name-mapping-helper" class="role-name">{{$trans->mapper}}</div>
                </div>
            </div>
            <div class="role-description-text">{{$trans->offer_roles}}<span id="role-text-rider" class="role-text-highlight">{{$trans->rider_explanation}}</span><span id="role-text-provider" class="role-text-highlight">{{$trans->provider_explanation}}</span>{{$trans->mapper_explanation}}<span id="role-text-notregistered" class="role-text-highlight">{{$trans->end_explain}}</span>{{$trans->call_to_action_explain}}
            </div>
        </div>
    </div>
</div>
<div class="data-number-frame">
    <div id="data-providers-container" class="data-container flex-center">
        <div id="data-providers" class="data-number" data-objective-number="0">0</div>
        <div class="data-description">{{$trans->providers}}</div>
    </div>
    <div id="data-kg-food-container" class="data-container flex-center">
        <div id="data-kg-food" class="data-number" data-objective-number="0">0</div>
        <div class="data-description">{{$trans->kg_food_saved}}</div>
    </div>
    <div id="data-deliverys-container" class="data-container flex-center">
        <div id="data-deliverys" class="data-number" data-objective-number="0">0</div>
        <div class="data-description">{{$trans->deliveries}}</div>
    </div>
</div>
</div>
<div id="how" class="separator-container separator-number-left separator-how">
    <div class="seprator-text separation-name">{{$trans->how}}</div>
    <div class="separator-line simple-line"></div>
    <div class="separation-number-container">
        <div class="seprator-text separation-number">02</div>
        <div class="separation-number-gradient"></div>
    </div>
</div>
<div id="faq-frame" class="faq-frame flex-center dark-interface-needed">
    <div class="faq-img-container">
        <img class="faq-img" src="./img/land/FAQ_image.png" alt="FAQ Image" draggable="false" loading="lazy">
    </div>
    <div class="faq-content-container flex-center">
        <div class="faq-options-container flex-center">
            <div class="faq-option-faq cursor-hoverable">FAQ</div>
            <div class="faq-option-chatbot-container cursor-hoverable">
                <div class="faq-option-chatbot ">{{$trans->virtual_assist}}</div>
                <svg class="faq-ai-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1080 1080">
                    <path d="M515.09 725.824L472.006 824.503C455.444 862.434 402.954 862.434 386.393 824.503L343.308 725.824C304.966 638.006 235.953 568.104 149.868 529.892L31.2779 477.251C-6.42601 460.515 -6.42594 405.665 31.2779 388.929L146.164 337.932C234.463 298.737 304.714 226.244 342.401 135.431L386.044 30.2693C402.239 -8.75637 456.159 -8.75646 472.355 30.2692L515.998 135.432C553.685 226.244 623.935 298.737 712.234 337.932L827.121 388.929C864.825 405.665 864.825 460.515 827.121 477.251L708.53 529.892C622.446 568.104 553.433 638.006 515.09 725.824Z"/>
                    <path d="M915.485 1036.98L903.367 1064.75C894.499 1085.08 866.349 1085.08 857.481 1064.75L845.364 1036.98C823.765 987.465 784.862 948.042 736.318 926.475L698.987 909.889C678.802 900.921 678.802 871.578 698.987 862.61L734.231 846.951C784.023 824.829 823.623 783.947 844.851 732.75L857.294 702.741C865.966 681.826 894.882 681.826 903.554 702.741L915.997 732.75C937.225 783.947 976.826 824.829 1026.62 846.951L1061.86 862.61C1082.05 871.578 1082.05 900.921 1061.86 909.889L1024.53 926.475C975.987 948.042 937.083 987.465 915.485 1036.98Z"/>
                </svg>
            </div>
            <div class="faq-option-selector simple-line"></div>
        </div>
       <div class="faq-questions-frame">
            <div class="faq-question-aswer-container">
                <div class="faq-question-container cursor-hoverable">
                    <div class="faq-number-question-container">
                        <div class="faq-number">001</div>
                        <div class="faq-question">{{$trans->what_is}}<span translate="no">StreetFeed</span></div>
                    </div>
                    <svg class="faq-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80">
                        <path d="M 0 0 L 100 0 L 50 80 Z"/>
                    </svg>
                </div>
                <div class="faq-answer-container flex-center flex-center">
                    <div class="faq-answer"><span translate="no">StreetFeed</span>{{$trans->response_what_is}}</div>
                </div>
            </div>
            <div class="faq-question-aswer-container">
                <div class="faq-question-container cursor-hoverable">
                    <div class="faq-number-question-container">
                        <div class="faq-number">002</div>
                        <div class="faq-question">{{$trans->how_does_it_work}}</div>
                    </div>
                    <svg class="faq-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80">
                        <path d="M 0 0 L 100 0 L 50 80 Z"/>
                    </svg>
                </div>
                <div class="faq-answer-container flex-center">
                    <div class="faq-answer"><span translate="no">StreetFeed</span>{{$trans->response_how_it_works}}</div>
                </div>
            </div>
            <div class="faq-question-aswer-container">
                <div class="faq-question-container cursor-hoverable">
                    <div class="faq-number-question-container">
                        <div class="faq-number">003</div>
                        <div class="faq-question">{{$trans->how_became_volunteer}}<span translate="no">StreetFeed</span></div>
                    </div>
                    <svg class="faq-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80">
                        <path d="M 0 0 L 100 0 L 50 80 Z"/>
                    </svg>
                </div>
                <div class="faq-answer-container flex-center">
                    <div class="faq-answer">{{$trans->response_how_become_volunteer_first}}<span translate="no">StreetFeed</span>{{$trans->response_how_become_volunteer_second}}</div>
                </div>
            </div>
            <div class="faq-question-aswer-container">
                <div class="faq-question-container cursor-hoverable">
                    <div class="faq-number-question-container">
                        <div class="faq-number">004</div>
                        <div class="faq-question">{{$trans->how_to_be_provider}}<span translate="no">StreetFeed</span>?</div>
                    </div>
                        <svg class="faq-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80">
                            <path d="M 0 0 L 100 0 L 50 80 Z"/>
                        </svg>
                </div>
                <div class="faq-answer-container flex-center">
                    <div class="faq-answer">{{$trans->response_how_to_be_provider}}</div>
                </div>
            </div>
            <div class="faq-question-aswer-container">
                <div class="faq-question-container cursor-hoverable">
                    <div class="faq-number-question-container">
                        <div class="faq-number">005</div>
                        <div class="faq-question">{{$trans->cost_to_use}}<span translate="no">StreetFeed</span>?</div>
                    </div>
                    <svg class="faq-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80">
                        <path d="M 0 0 L 100 0 L 50 80 Z"/>
                    </svg>
                </div>
                <div class="faq-answer-container flex-center">
                    <div class="faq-answer">{{$trans->response_cost_to_use_first}}<span translate="no">StreetFeed</span>{{$trans->response_cost_to_use_second}}</div>
                </div>
            </div>
            <div class="faq-question-aswer-container">
                <div class="faq-question-container cursor-hoverable">
                    <div class="faq-number-question-container">
                        <div class="faq-number">006</div>
                        <div class="faq-question">{{$trans->does}}<span translate="no">StreetFeed</span>{{$trans->scale_in_future}}</div>
                    </div>
                    <svg class="faq-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 80">
                        <path d="M 0 0 L 100 0 L 50 80 Z"/>
                    </svg>
                </div>
                <div class="faq-answer-container flex-center">
                    <div class="faq-answer">{{$trans->respone_scale_in_future_first}}<span translate="no">StreetFeed</span>{{$trans->respone_scale_in_future_second}}</div>
                </div>
            </div>
       </div>
       <div class="faq-chatbot-frame">
           <div class="faq-chatbot-messages-frame">
                <div class="faq-message chatbot-message"><span class="faq-chatbot-text">{{$trans->glad_to_response}}<span translate="no">StreetFeed</span>!</span><span class="chatbot-waiting-indicator"></span></div>
            </div>
            <div class="faq-user-input">
                <textarea class="chatbot-text-input" type="textarea" placeholder="{{$trans->message_to_ai}}"></textarea>
                <div class="chatbot-send-message-container">
                    <button class="chatbot-send-message message-invalid cursor-hoverable">
                        <i class="chatbot-send-message-icon fa-regular fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="who" class="separator-container separator-number-rigth separator-who">
    <div class="seprator-text separation-name">{{$trans->who}}</div>
    <div class="separator-line simple-line"></div>
    <div class="separation-number-container">
        <div class="seprator-text separation-number">03</div>
        <div class="separation-number-gradient"></div>
    </div>
</div>

<div class="who-frame">
    <div class="who-dev-info-container">
        <div class="who-info-container">
            <div class="who-dev-info who-full-name">JAVIER DÍAZ</div>
            <div class="who-dev-info who-dev-description">DESIGN & FRONT-END DEVELOPMENT</div>
        </div>
        <a class="who-img-frame" href="https://www.linkedin.com/in/javier-d%C3%ADaz-neira-120385153/" target="_blank">
            <div class="who-img-outer-border"></div>
            <div class="who-img-container who-img-javi dev-img-shown">
                <img class="who-img" src="img/land/who-javi.jpg" alt="Javier Díaz Dev Photo" draggable="false">
            </div>
            <div class="who-img-container who-img-pol">
                <img class="who-img" src="img/land/who-pol.png" alt="Pol Crespo Dev Photo" draggable="false">
            </div>
            <div class="who-img-container who-img-mario">
                <img class="who-img" src="img/land/who-mario.png" alt="Mario Molina Dev Photo" draggable="false">
            </div>
            <div class="who-img-container who-img-josue">
                <img class="who-img" src="img/land/who-josue.jpeg" alt="Josue Quispe Dev Photo" draggable="false">
            </div>
        </a>
    </div>
    <div class="who-dev-selector-container">
        <div class="who-dev-names-container">
            <div class="who-dev-name-container cursor-hoverable dev-shown" data-dev-index="0">
                <div class="who-dev-name">JAVI</div>
                <div class="who-name-mask"></div>
            </div>
            <div class="who-dev-name-container cursor-hoverable" data-dev-index="1">
                <div class="who-dev-name">MARIO</div>
                <div class="who-name-mask"></div>
            </div>
            <div class="who-dev-name-container cursor-hoverable" data-dev-index="2">
                <div class="who-dev-name">POL</div>
                <div class="who-name-mask"></div>
            </div>
            <div class="who-dev-name-container cursor-hoverable" data-dev-index="3">
                <div class="who-dev-name">JOSUE</div>
                <div class="who-name-mask"></div>
            </div>
        </div>
    </div>
</div>
<div class="call-to-action-frame">
    <div class="call-to-action-container">       
        <video class="call-to-action-interactive-video" src="img/land/video_interactivo.mp4" muted></video>
        <div class="call-to-action-text-container flex-center">
            <div class="call-to-action-text">{{$trans->join_adventure}}</div>
            <div class="call-to-action-button nav-option-container nav-button-option nav-link-to-login cursor-hoverable go-to-login-btn">
                <div class="option-overflow-window">
                    <div class="nav-option-name-container">
                        <div class="nav-option-name">{{$trans->start_helping}}</div>
                        <div class="nav-option-name">{{$trans->start_helping}}</div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<div id="footer" class="footer dark-interface-needed">
    <div class="footer-message">{{$trans->start_helping}}</div>
    <div class="footer-links-frame">
        <div class=footer-links-container>
            <div class="footer-links-title">{{$trans->legal}}</div>
            <div class="footer-links">
                <div class="footer-link cursor-hoverable">{{$trans->terms_of_use}}</div>
                <div class="footer-link cursor-hoverable">{{$trans->coockie_policy}}</div>
                <div class="footer-link cursor-hoverable">{{$trans->terms_and_conditions}}</div>
            </div>
        </div>
        <div class=footer-links-container>
            <div class="footer-links-title">{{$trans->contact}}</div>
                <div class="footer-links">
                    <div class="footer-link">+34 999 999 999</div>
                    <div class="footer-link">info@streetfeed.com</div>
                </div>
            </div>
        </div>
        <div class="footer-logo" translate="no">STREETFEED</div>
    </div>
</div>
@endsection

@section('imports')
    @vite(['resources/css/app-land.css', 'resources/js/app-land.js'])
@endsection