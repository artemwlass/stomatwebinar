<div>
    <section class="callback" id="callback"  wire:ignore>

        <div class="container callback__container" >

            <div class="info__block mobile">
                <div class="title">
                    {!! $support->text !!}
                </div>

                <div class="contacts">
                    <a href="tel:{{$support->phone}}">
                        {{$support->phone}}
                    </a>

                    <a href="mailto:{{$support->email}}">
                        {{$support->email}}
                    </a>
                </div>

                    <div class="socials">
                        <a href="{{$support->viber}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="65" viewBox="0 0 66 65" fill="none">
                                <ellipse cx="33" cy="32.5" rx="33" ry="32.5" fill="#7347EF"/>
                                <path d="M43.9997 30.8763C44.0374 26.108 40.1701 21.737 35.3796 21.1319C35.2838 21.1204 35.1802 21.1022 35.0703 21.0824C34.8295 21.034 34.5853 21.0065 34.3402 21C33.3573 21 33.0951 21.7255 33.026 22.1558C32.9585 22.5763 33.0228 22.9307 33.216 23.2061C33.541 23.6694 34.1141 23.7519 34.5741 23.8178C34.7076 23.8376 34.8348 23.8557 34.9416 23.8805C39.2469 24.8912 40.6961 26.479 41.4043 30.9621C41.4215 31.0709 41.4294 31.2061 41.4388 31.3495C41.4702 31.8854 41.533 33 42.6745 33C42.7687 33 42.8724 32.9918 42.9791 32.9753C44.0405 32.8054 44.0076 31.7865 43.9919 31.2968C43.9872 31.1583 43.9825 31.028 43.995 30.9406C43.9975 30.9188 43.9986 30.8967 43.9982 30.8747L43.9997 30.8763Z" fill="white"/>
                                <path d="M33.99 19.5526C34.1173 19.562 34.2353 19.5714 34.3346 19.5854C41.3238 20.6667 44.5382 23.9948 45.4276 31.0754C45.4431 31.1955 45.4462 31.3422 45.4478 31.4967C45.4571 32.0506 45.4757 33.2021 46.705 33.2255H46.7423C47.1287 33.2255 47.4345 33.1084 47.6549 32.8775C48.0367 32.4765 48.0119 31.8789 47.9886 31.3984C47.984 31.2798 47.9793 31.169 47.9793 31.0707C48.0693 23.831 41.8329 17.2637 34.6373 17.0203C34.6062 17.0203 34.5783 17.0203 34.5504 17.025C34.522 17.0286 34.4935 17.0301 34.465 17.0296C34.392 17.0296 34.3051 17.0234 34.2104 17.0172C34.0987 17.0094 33.9699 17 33.8379 17C32.6925 17 32.4752 17.8192 32.4472 18.3075C32.3836 19.4356 33.4685 19.5152 33.99 19.5526ZM45.0908 40.2265C44.9408 40.1119 44.7923 39.9954 44.6453 39.877C43.8817 39.2591 43.0699 38.6912 42.2861 38.1404L41.7972 37.7971C40.7914 37.0872 39.8881 36.7424 39.0344 36.7424C37.8828 36.7424 36.8801 37.3821 36.0513 38.6412C35.6849 39.1998 35.2395 39.4713 34.6916 39.4713C34.311 39.4579 33.9376 39.3638 33.5958 39.1951C30.3519 37.716 28.033 35.4473 26.7075 32.4531C26.0665 31.0052 26.2744 30.0596 27.4013 29.2888C28.0423 28.852 29.2328 28.0391 29.1505 26.4803C29.0543 24.7125 25.1724 19.3904 23.5365 18.7865C22.8371 18.5301 22.0705 18.5279 21.3697 18.7803C19.4901 19.4153 18.1429 20.5325 17.4677 22.007C16.8158 23.4331 16.8469 25.1073 17.5515 26.8486C19.5926 31.8836 22.4609 36.2743 26.0789 39.8973C29.6193 43.4438 33.9714 46.3475 39.0127 48.5304C39.4675 48.7269 39.944 48.8346 40.2932 48.9126C40.4112 48.9391 40.5136 48.9626 40.5881 48.9828C40.6291 48.9939 40.6714 48.9997 40.7138 49H40.7542C43.1258 49 45.974 46.8218 46.8478 44.3394C47.6145 42.1644 46.2145 41.0893 45.0908 40.2265ZM35.0393 25.3054C34.6342 25.3148 33.7883 25.3366 33.4918 26.201C33.3521 26.6067 33.3692 26.9562 33.5415 27.2449C33.7929 27.6661 34.2756 27.7972 34.7133 27.869C36.3042 28.1249 37.1222 29.008 37.2852 30.651C37.3612 31.4155 37.875 31.9507 38.5315 31.9507C38.5814 31.9506 38.6311 31.9475 38.6805 31.9413C39.4721 31.8477 39.8555 31.2626 39.8214 30.2032C39.8338 29.0985 39.2595 27.844 38.2801 26.8454C37.2992 25.8437 36.1164 25.2789 35.0393 25.3054Z" fill="white"/>
                            </svg>
                        </a>
                        <a href="{{$support->whatsup}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="65" viewBox="0 0 66 65" fill="none">
                                <ellipse cx="33" cy="32.5" rx="33" ry="32.5" fill="#1EAA2C"/>
                                <path d="M46.8252 39.6339C46.6752 39.5193 46.5267 39.4028 46.3797 39.2844C45.6161 38.6665 44.8043 38.0986 44.0205 37.5478L43.5316 37.2045C42.5258 36.4946 41.6225 36.1498 40.7688 36.1498C39.6171 36.1498 38.6145 36.7895 37.7856 38.0487C37.4193 38.6072 36.9739 38.8787 36.426 38.8787C36.0454 38.8654 35.672 38.7712 35.3302 38.6026C32.0862 37.1234 29.7674 34.8547 28.4419 31.8605C27.8008 30.4126 28.0088 29.4671 29.1357 28.6963C29.7767 28.2594 30.9672 27.4465 30.8849 25.8878C30.7887 24.1199 26.9068 18.7978 25.2709 18.194C24.5715 17.9375 23.8049 17.9353 23.1041 18.1877C21.2245 18.8228 19.8773 19.9399 19.2021 21.4144C18.5502 22.8405 18.5812 24.5147 19.2859 26.256C21.3269 31.291 24.1953 35.6817 27.8133 39.3047C31.3536 42.8512 35.7058 45.7549 40.7471 47.9378C41.2018 48.1344 41.6783 48.242 42.0276 48.32C42.1455 48.3466 42.248 48.37 42.3225 48.3903C42.3635 48.4014 42.4057 48.4071 42.4482 48.4074H42.4886C44.8602 48.4074 47.7083 46.2293 48.5822 43.7468C49.3489 41.5718 47.9489 40.4967 46.8252 39.6339Z" fill="white"/>
                            </svg>
                        </a>
                        <a href="{{$support->telegram}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="66" height="65" viewBox="0 0 66 65" fill="none">
                                <ellipse cx="33" cy="32.5" rx="33" ry="32.5" fill="#47C0F3"/>
                                <path d="M44.7406 19.2384C44.7406 19.2384 47.7008 18.0697 47.4541 20.908C47.3719 22.0767 46.6319 26.1672 46.0563 30.5916L44.0828 43.698C44.0828 43.698 43.9184 45.618 42.4382 45.9519C40.9581 46.2858 38.7379 44.7832 38.3267 44.4493C37.9978 44.1989 32.1597 40.4422 30.1039 38.6057C29.5283 38.1048 28.8704 37.103 30.1861 35.9343L38.8202 27.5864C39.8069 26.5846 40.7936 24.2472 36.6822 27.0855L25.1702 35.0161C25.1702 35.0161 23.8545 35.8508 21.3877 35.0996L16.0428 33.4299C16.0428 33.4299 14.0693 32.1778 17.4407 30.9255C25.6636 27.0019 35.7777 22.9949 44.7406 19.2384Z" fill="white"/>
                            </svg>
                        </a>
                    </div>

                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="317" height="314" viewBox="0 0 317 314" fill="none">
                            <path d="M239.616 197.21C215.683 240.126 185.62 279.088 142.715 293.205C128.998 297.723 115.57 299.417 103.314 299.981C51.0688 300.827 15.1678 273.441 14 226.009C14 222.339 18.3779 220.644 21.0041 222.621C22.9389 224.075 23.0493 225.472 23.6332 227.166C23.9237 228.013 27.1338 246.619 52.5271 251.419C54.6856 251.827 58.9474 252.266 58.9474 252.266C58.9474 252.266 61.5765 252.577 63.6187 252.549C73.833 252.549 82.2984 249.16 88.4281 242.384C102.146 227.421 98.6424 200.316 98.0584 198.057C91.9287 132.273 96.3067 86.8168 111.192 63.1005V62.818C131.333 28.0907 164.605 11.7151 210.721 14.2562C233.778 15.1032 253.918 21.0322 265.592 24.4203C268.511 25.2673 268.219 28.373 265.884 30.067C253.042 39.9488 221.812 37.4078 221.812 37.6901C218.893 37.9725 216.85 40.7958 217.142 43.337C217.434 45.8778 220.353 47.2895 222.979 47.8542C223.855 47.8542 254.793 54.6304 286.607 29.7847C309.373 12.5622 349.067 23.0086 375.335 41.0782C399.269 57.1713 409.192 83.711 405.106 119.286C401.896 146.672 391.388 169.824 391.388 170.106L391.096 170.671C390.805 171.518 355.197 274.288 291.569 268.642C279.31 267.512 269.095 261.583 260.631 251.419C248.956 236.738 242.827 216.409 239.616 197.21ZM182.993 148.649C190.582 150.06 197.295 143.849 195.836 136.226C194.96 131.991 191.457 128.603 187.371 128.038C179.783 126.626 173.07 132.838 174.529 140.461C175.113 144.414 178.615 147.801 182.993 148.649Z" stroke="white" stroke-width="27"/>
                          </svg>
                    </span>

                </div>

                <div class="callback__wrapper">



                    <div class="callback__info">

                        <div class="info__block desktop">
                            <div class="title">
                                {!! $support->text !!}
                            </div>

                            <div class="contacts">
                                <a href="tel:{{$support->phone}}">
                                    {{$support->phone}}
                                </a>

                                <a href="mailto:{{$support->email}}">
                                    {{$support->email}}
                                </a>
                            </div>

                                <div class="socials">
                                    <a href="{{$support->viber}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="66" height="65" viewBox="0 0 66 65" fill="none">
                                            <ellipse cx="33" cy="32.5" rx="33" ry="32.5" fill="#7347EF"/>
                                            <path d="M43.9997 30.8763C44.0374 26.108 40.1701 21.737 35.3796 21.1319C35.2838 21.1204 35.1802 21.1022 35.0703 21.0824C34.8295 21.034 34.5853 21.0065 34.3402 21C33.3573 21 33.0951 21.7255 33.026 22.1558C32.9585 22.5763 33.0228 22.9307 33.216 23.2061C33.541 23.6694 34.1141 23.7519 34.5741 23.8178C34.7076 23.8376 34.8348 23.8557 34.9416 23.8805C39.2469 24.8912 40.6961 26.479 41.4043 30.9621C41.4215 31.0709 41.4294 31.2061 41.4388 31.3495C41.4702 31.8854 41.533 33 42.6745 33C42.7687 33 42.8724 32.9918 42.9791 32.9753C44.0405 32.8054 44.0076 31.7865 43.9919 31.2968C43.9872 31.1583 43.9825 31.028 43.995 30.9406C43.9975 30.9188 43.9986 30.8967 43.9982 30.8747L43.9997 30.8763Z" fill="white"/>
                                            <path d="M33.99 19.5526C34.1173 19.562 34.2353 19.5714 34.3346 19.5854C41.3238 20.6667 44.5382 23.9948 45.4276 31.0754C45.4431 31.1955 45.4462 31.3422 45.4478 31.4967C45.4571 32.0506 45.4757 33.2021 46.705 33.2255H46.7423C47.1287 33.2255 47.4345 33.1084 47.6549 32.8775C48.0367 32.4765 48.0119 31.8789 47.9886 31.3984C47.984 31.2798 47.9793 31.169 47.9793 31.0707C48.0693 23.831 41.8329 17.2637 34.6373 17.0203C34.6062 17.0203 34.5783 17.0203 34.5504 17.025C34.522 17.0286 34.4935 17.0301 34.465 17.0296C34.392 17.0296 34.3051 17.0234 34.2104 17.0172C34.0987 17.0094 33.9699 17 33.8379 17C32.6925 17 32.4752 17.8192 32.4472 18.3075C32.3836 19.4356 33.4685 19.5152 33.99 19.5526ZM45.0908 40.2265C44.9408 40.1119 44.7923 39.9954 44.6453 39.877C43.8817 39.2591 43.0699 38.6912 42.2861 38.1404L41.7972 37.7971C40.7914 37.0872 39.8881 36.7424 39.0344 36.7424C37.8828 36.7424 36.8801 37.3821 36.0513 38.6412C35.6849 39.1998 35.2395 39.4713 34.6916 39.4713C34.311 39.4579 33.9376 39.3638 33.5958 39.1951C30.3519 37.716 28.033 35.4473 26.7075 32.4531C26.0665 31.0052 26.2744 30.0596 27.4013 29.2888C28.0423 28.852 29.2328 28.0391 29.1505 26.4803C29.0543 24.7125 25.1724 19.3904 23.5365 18.7865C22.8371 18.5301 22.0705 18.5279 21.3697 18.7803C19.4901 19.4153 18.1429 20.5325 17.4677 22.007C16.8158 23.4331 16.8469 25.1073 17.5515 26.8486C19.5926 31.8836 22.4609 36.2743 26.0789 39.8973C29.6193 43.4438 33.9714 46.3475 39.0127 48.5304C39.4675 48.7269 39.944 48.8346 40.2932 48.9126C40.4112 48.9391 40.5136 48.9626 40.5881 48.9828C40.6291 48.9939 40.6714 48.9997 40.7138 49H40.7542C43.1258 49 45.974 46.8218 46.8478 44.3394C47.6145 42.1644 46.2145 41.0893 45.0908 40.2265ZM35.0393 25.3054C34.6342 25.3148 33.7883 25.3366 33.4918 26.201C33.3521 26.6067 33.3692 26.9562 33.5415 27.2449C33.7929 27.6661 34.2756 27.7972 34.7133 27.869C36.3042 28.1249 37.1222 29.008 37.2852 30.651C37.3612 31.4155 37.875 31.9507 38.5315 31.9507C38.5814 31.9506 38.6311 31.9475 38.6805 31.9413C39.4721 31.8477 39.8555 31.2626 39.8214 30.2032C39.8338 29.0985 39.2595 27.844 38.2801 26.8454C37.2992 25.8437 36.1164 25.2789 35.0393 25.3054Z" fill="white"/>
                                        </svg>
                                    </a>
                                    <a href="{{$support->whatsup}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="66" height="65" viewBox="0 0 66 65" fill="none">
                                            <ellipse cx="33" cy="32.5" rx="33" ry="32.5" fill="#1EAA2C"/>
                                            <path d="M46.8252 39.6339C46.6752 39.5193 46.5267 39.4028 46.3797 39.2844C45.6161 38.6665 44.8043 38.0986 44.0205 37.5478L43.5316 37.2045C42.5258 36.4946 41.6225 36.1498 40.7688 36.1498C39.6171 36.1498 38.6145 36.7895 37.7856 38.0487C37.4193 38.6072 36.9739 38.8787 36.426 38.8787C36.0454 38.8654 35.672 38.7712 35.3302 38.6026C32.0862 37.1234 29.7674 34.8547 28.4419 31.8605C27.8008 30.4126 28.0088 29.4671 29.1357 28.6963C29.7767 28.2594 30.9672 27.4465 30.8849 25.8878C30.7887 24.1199 26.9068 18.7978 25.2709 18.194C24.5715 17.9375 23.8049 17.9353 23.1041 18.1877C21.2245 18.8228 19.8773 19.9399 19.2021 21.4144C18.5502 22.8405 18.5812 24.5147 19.2859 26.256C21.3269 31.291 24.1953 35.6817 27.8133 39.3047C31.3536 42.8512 35.7058 45.7549 40.7471 47.9378C41.2018 48.1344 41.6783 48.242 42.0276 48.32C42.1455 48.3466 42.248 48.37 42.3225 48.3903C42.3635 48.4014 42.4057 48.4071 42.4482 48.4074H42.4886C44.8602 48.4074 47.7083 46.2293 48.5822 43.7468C49.3489 41.5718 47.9489 40.4967 46.8252 39.6339Z" fill="white"/>
                                        </svg>
                                    </a>
                                    <a href="{{$support->telegram}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="66" height="65" viewBox="0 0 66 65" fill="none">
                                            <ellipse cx="33" cy="32.5" rx="33" ry="32.5" fill="#47C0F3"/>
                                            <path d="M44.7406 19.2384C44.7406 19.2384 47.7008 18.0697 47.4541 20.908C47.3719 22.0767 46.6319 26.1672 46.0563 30.5916L44.0828 43.698C44.0828 43.698 43.9184 45.618 42.4382 45.9519C40.9581 46.2858 38.7379 44.7832 38.3267 44.4493C37.9978 44.1989 32.1597 40.4422 30.1039 38.6057C29.5283 38.1048 28.8704 37.103 30.1861 35.9343L38.8202 27.5864C39.8069 26.5846 40.7936 24.2472 36.6822 27.0855L25.1702 35.0161C25.1702 35.0161 23.8545 35.8508 21.3877 35.0996L16.0428 33.4299C16.0428 33.4299 14.0693 32.1778 17.4407 30.9255C25.6636 27.0019 35.7777 22.9949 44.7406 19.2384Z" fill="white"/>
                                        </svg>
                                    </a>
                                </div>

                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="317" height="314" viewBox="0 0 317 314" fill="none">
                                    <path d="M239.616 197.21C215.683 240.126 185.62 279.088 142.715 293.205C128.998 297.723 115.57 299.417 103.314 299.981C51.0688 300.827 15.1678 273.441 14 226.009C14 222.339 18.3779 220.644 21.0041 222.621C22.9389 224.075 23.0493 225.472 23.6332 227.166C23.9237 228.013 27.1338 246.619 52.5271 251.419C54.6856 251.827 58.9474 252.266 58.9474 252.266C58.9474 252.266 61.5765 252.577 63.6187 252.549C73.833 252.549 82.2984 249.16 88.4281 242.384C102.146 227.421 98.6424 200.316 98.0584 198.057C91.9287 132.273 96.3067 86.8168 111.192 63.1005V62.818C131.333 28.0907 164.605 11.7151 210.721 14.2562C233.778 15.1032 253.918 21.0322 265.592 24.4203C268.511 25.2673 268.219 28.373 265.884 30.067C253.042 39.9488 221.812 37.4078 221.812 37.6901C218.893 37.9725 216.85 40.7958 217.142 43.337C217.434 45.8778 220.353 47.2895 222.979 47.8542C223.855 47.8542 254.793 54.6304 286.607 29.7847C309.373 12.5622 349.067 23.0086 375.335 41.0782C399.269 57.1713 409.192 83.711 405.106 119.286C401.896 146.672 391.388 169.824 391.388 170.106L391.096 170.671C390.805 171.518 355.197 274.288 291.569 268.642C279.31 267.512 269.095 261.583 260.631 251.419C248.956 236.738 242.827 216.409 239.616 197.21ZM182.993 148.649C190.582 150.06 197.295 143.849 195.836 136.226C194.96 131.991 191.457 128.603 187.371 128.038C179.783 126.626 173.07 132.838 174.529 140.461C175.113 144.414 178.615 147.801 182.993 148.649Z" stroke="white" stroke-width="27"/>
                                  </svg>
                            </span>

                            </div>

                            <div class="img__block desktop">
                                <img src="{{asset('storage/' . $support->image1)}}" class="img-fluid" alt="">
                            </div>

                            <div class="img__block mobile">
                                <img src="{{asset('storage/' . $support->image1)}}" class="img-fluid tablet" alt="">
                                <img src="{{asset('storage/' . $support->image1)}}" class="img-fluid mobile" alt="">
                            </div>

                        </div>

                        <div class="callback__form" >



                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="callBackModalLabel">Залишились питання?</h2>
                                    <p class="modal-subtitle">Заповніть форму нижче і ми зв'яжемося з вами найближчим часом</p>
                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                </div>
                                <div class="modal-body" >
                                    <!-- Форма обратного звонка -->
                                    <form class="callback-form">
                                        <div class="mb-4">
                                            <!-- <label for="name" class="form-label">Ваше имя</label> -->
                                            <input placeholder="Ваше імя"type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-4">
                                            <!-- <label for="phone" class="form-label">Номер телефона</label> -->
                                            <input placeholder="Ваш телефон" type="tel" class="form-control" id="phone" name="phone" required>
                                        </div>
                                        <div class="mb-4">
                                            <!-- <label for="email" class="form-label">Ваша пошта</label> -->
                                            <input placeholder="Ваша пошта"  type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-4">
                                            <!-- <label for="comment" class="form-label">Ваш коментар</label> -->
                                            <textarea placeholder="Ваше запитання" class="form-control" id="comment" name="comment" required></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success">Відправити</button>
                                        <div class="form-check mt-2">
                                            <input type="checkbox" class="form-check-input" id="termsCheckbox" required>
                                            <label class="form-check-label" for="termsCheckbox">Згоден(а) з політикою конфіденційності</label>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>

    </section>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        const form = document.querySelector('.callback-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            // Сбор данных из формы
            const formData = {
                name: form.querySelector('#name').value,
                phone: form.querySelector('#phone').value,
                email: form.querySelector('#email').value,
                text: form.querySelector('#comment').value
            };

            // Отправка данных через Livewire
        @this.dispatch('formSubmitted', { formData: formData });

            // Очистка формы
            form.reset();
        });
    })
</script>


