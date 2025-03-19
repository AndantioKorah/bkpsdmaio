<style>


.parent {
display: grid;
/* grid-template-columns: repeat(5, 1fr); */
/* grid-template-rows: repeat(5, 1fr); */
grid-column-gap: 0px;
grid-row-gap: 0px;
/* width:100%; */
}

.div4 { grid-area: 1 / 1 / 2 / 2;border: 2px solid;background-color: #fcb92c }
.div7 { grid-area: 1 / 2 / 2 / 3;border-top: 2px solid;border-bottom: 2px solid;background-color: #1cbb8c }
.div9 { grid-area: 1 / 3 / 2 / 4;border: 2px solid;background-color: #1cbb8c }
.div2 { grid-area: 2 / 1 / 3 / 2;border-left: 2px solid; border-right: 2px solid; background-color: #be4d4d}
.div5 { grid-area: 2 / 2 / 3 / 3;background-color: #fcb92c }
.div8 { grid-area: 2 / 3 / 3 / 4;border-right: 2px solid;border-left: 2px solid;background-color: #1cbb8c }
.div1 { grid-area: 3 / 1 / 4 / 2;border: 2px solid; background-color: #be4d4d}
.div3 { grid-area: 3 / 2 / 4 / 3;border-bottom: 2px solid;border-top: 2px solid; background-color: #be4d4d}
.div6 { grid-area: 3 / 3 / 4 / 4;border: 2px solid;background-color: #fcb92c }

.vertical-lr {
  writing-mode: vertical-lr;
}

.vertical-rl {
  writing-mode: vertical-rl;
}

.rotated {
  transform: rotate(180deg);
}

.sideways-lr {
  writing-mode: sideways-lr;
}

.only-rotate {
  inline-size: fit-content;
  transform: rotate(-90deg);
}

table, th, td {
  border: 1px rgba(0, 0, 0, 0);
  /* background-color:#2e4963; */
  /* color:#fff; */
}

label {
  color:white
}

   
.cardz {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
   }

   img {
      max-width: 100%;
      width: 100%;
      vertical-align: bottom;
   }

   h1, h2, p {
      margin: 0;
   }

   .animation01 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    width: 100%;
    height: 100%;
}

.animation01 div {
    width: 20%;
    height: 100%;
    animation: animation01 0.275s ease-in forwards;
    transform-origin: bottom;
    opacity: 0;
}

.animation01 div:nth-child(1) {
    background-color: #d55959;
    animation-delay: 0.4s;
}

.animation01 div:nth-child(2) {
    background-color: #ffe08b;
    animation-delay: 0.3s;
}

.animation01 div:nth-child(3) {
    background-color: #75cfb9;
    animation-delay: 0.2s;
}

.animation01 div:nth-child(4) {
    background-color: #f1a05b;
    animation-delay: 0.1s;
}

.animation01 div:nth-child(5) {
    background-color: #78bee4;
}

@keyframes animation01 {
    0% {
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===================
animation02
====================*/

.animation02 {
    position: absolute;
    width: 100%;
    height: 100%;
}

.animation02 div {
    position: absolute;
    width: 0;
    height: 0;
    animation: animation02 0.2s ease-in 0.3s forwards;
    opacity: 0;
}

.animation02 div:nth-child(1) {
    top: 0;
    left: 0;
    border-top: 100vh solid transparent;
    border-right: 100vw solid #f2f3df;
    transform-origin: bottom right;
}

.animation02 div:nth-child(2) {
    right: 0;
    bottom: 0;
    border-bottom: 100vh solid transparent;
    border-left: 100vw solid #f2f3df;
    transform-origin: top left;
}

@keyframes animation02 {
    0% {
        transform: scale3d(0, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===================
animation03
====================*/

.animation03 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 13vw;
    height: 13vw;
}

.animation03 .circle {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transform-origin: center;
    background-color: transparent;
    z-index: 9998;
}

.animation03 .circle_element01 {
    width: 13vw;
    height: 13vw;
    border: 0.25vw solid #54988b;
    border-radius: 50%;
    animation: animation03_circle 0.3s ease-in-out 0.3s forwards, animation03_circle_element01 0.3s linear 0.6s forwards;
    opacity: 0;
}

.animation03 .circle_element02 {
    width: 9vw;
    height: 9vw;
    border: 0.5vw solid #4b5e58;
    border-radius: 50%;
    animation: animation03_circle 0.3s ease-in-out 0.3s forwards, animation03_circle_element02 0.2s linear 0.5s forwards;
    opacity: 0;
}

.animation03 .circle_element03 {
    width: 4vw;
    height: 4vw;
    border: 1vw solid #404a52;
    border-radius: 50%;
    animation: animation03_circle 0.3s ease-in-out 0.3s forwards, animation03_circle_element03 0.15s linear 0.5s forwards;
    opacity: 0;
}

@keyframes animation03_circle {
    0% {
        transform: scale3d(0, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

@keyframes animation03_circle_element01 {
    0% {
        border: 0.25vw solid #54988b;
    }
    100% {
        border: 0 solid #54988b;
    }
}

@keyframes animation03_circle_element02 {
    0% {
        border: 0.5vw solid #4b5e58;
    }
    100% {
        border: 0 solid #4b5e58;
    }
}

@keyframes animation03_circle_element03 {
    0% {
        border: 1vw solid #404a52;
    }
    100% {
        border: 0 solid #404a52;
    }
}

/*===================
animation04
====================*/

.animation04 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
    z-index: 9999;
}

.animation04 .line_wrapper {
    position: absolute;
    opacity: 0;
}

.animation04 .line {
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #fff;
    opacity: 0;
}

/*===========
line01
===========*/

.animation04 .line_wrapper01 {
    top: -20%;
    left: 50%;
    width: 2.5%;
    height: 30%;
    animation: animation04_line_wrapper01 0.45s ease-in 0.8s forwards;
}

.animation04 .line01 {
    animation: animation04_line01 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper01 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation04_line01 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line02
===========*/

.animation04 .rotate45 {
    display: block;
    position: absolute;
    top: 22.5%;
    left: 50%;
    width: 100%;
    height: 100%;
    transform: rotate(45deg);
}

.animation04 .line_wrapper02 {
    width: 2.5%;
    height: 30%;
    animation: animation04_line_wrapper02 0.45s ease-in 0.8s forwards;
}

.animation04 .line02 {
    animation: animation04_line02 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper02 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation04_line02 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line03
===========*/

.animation04 .line_wrapper03 {
    top: 50%;
    left: 90%;
    width: 30%;
    height: 2.5%;
    animation: animation04_line_wrapper03 0.45s ease-in 0.8s forwards;
}

.animation04 .line03 {
    animation: animation04_line03 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper03 {
    0% {
        transform-origin: right;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: right;
        transform: scale3d(0, 1, 1);
        opacity: 1;
    }
}

@keyframes animation04_line03 {
    0% {
        transform-origin: left;
        transform: scale3d(0, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: left;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line04
===========*/

.animation04 .rotate135 {
    display: block;
    position: absolute;
    top: 49.5%;
    left: -22%;
    width: 100%;
    height: 100%;
    transform: rotate(135deg);
}

.animation04 .line_wrapper04 {
    width: 2.5%;
    height: 30%;
    animation: animation04_line_wrapper04 0.45s ease-in 0.8s forwards;
}

.animation04 .line04 {
    animation: animation04_line04 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper04 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation04_line04 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line05
===========*/

.animation04 .line_wrapper05 {
    top: 90%;
    left: 50%;
    width: 2.5%;
    height: 30%;
    animation: animation04_line_wrapper05 0.45s ease-in 0.8s forwards;
}

.animation04 .line05 {
    animation: animation04_line05 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper05 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation04_line05 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line06
===========*/

.animation04 .rotate-135 {
    display: block;
    position: absolute;
    top: -19.5%;
    left: -48%;
    width: 100%;
    height: 100%;
    transform: rotate(-135deg);
}

.animation04 .line_wrapper06 {
    width: 2.5%;
    height: 30%;
    animation: animation04_line_wrapper06 0.45s ease-in 0.8s forwards;
}

.animation04 .line06 {
    animation: animation04_line06 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper06 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation04_line06 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line07
===========*/

.animation04 .line_wrapper07 {
    top: 50%;
    left: -20%;
    width: 30%;
    height: 2.5%;
    animation: animation04_line_wrapper07 0.45s ease-in 0.8s forwards;
}

.animation04 .line07 {
    animation: animation04_line07 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper07 {
    0% {
        transform-origin: left;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: left;
        transform: scale3d(0, 1, 1);
        opacity: 1;
    }
}

@keyframes animation04_line07 {
    0% {
        transform-origin: right;
        transform: scale3d(0, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: right;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===========
line08
===========*/

.animation04 .rotate-45 {
    display: block;
    position: absolute;
    top: -49.0%;
    left: 20%;
    width: 100%;
    height: 100%;
    transform: rotate(-45deg);
}

.animation04 .line_wrapper08 {
    width: 2.5%;
    height: 30%;
    animation: animation04_line_wrapper08 0.45s ease-in 0.8s forwards;
}

.animation04 .line08 {
    animation: animation04_line08 0.45s ease-in 0.5s forwards;
}

@keyframes animation04_line_wrapper08 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation04_line08 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===================
animation05
====================*/

.animation05 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
}

.double_wrapper02 {
    position: relative;
    width: 100%;
    height: 100%;
    animation: animation05_double forwards;
    opacity: 0;
}

.double_wrapper01 {
    display: block;
    position: absolute;
    border-radius: 50%;
    overflow: hidden;
}

.double_wrapper01::before {
    content: "";
    display: block;
    position: absolute;
    background: #f2f3df;
    z-index: 2;
}

.double_wrapper01::after {
    content: "";
    display: block;
    position: absolute;
    background: #f2f3df;
    z-index: 3;
}

.double_block {
    position: absolute;
    background: #f2f3df;
    border-radius: 50%;
}

/*==============
green circle
==============*/

.green02 {
    top: 0;
    animation-delay: 1.3s;
}

.green01 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 34vw;
    height: 34vw;
    background: #75cfb9;
    z-index: 1;
}

.green01::before {
    top: 0;
    left: 17vw;
    width: 34vw;
    height: 34vw;
    transform-origin: left 17vw;
    animation: rotate-circle-right 0.5s linear 1.55s forwards;
}

.green01::after {
    top: 0;
    left: -17vw;
    width: 34vw;
    height: 34vw;
    transform-origin: right 17vw;
    animation: rotate-circle-left 0.5s linear 1.3s forwards;
}

.green00 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 9vw;
    height: 9vw;
    z-index: 4;
}

/*==============
navy circle
==============*/

.navy02 {
    top: -100%;
    animation-delay: 1.4s;
}

.navy01 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-20deg);
    width: 25vw;
    height: 25vw;
    background: #485973;
    z-index: 1;
}

.navy01::before {
    top: 0;
    left: 12.5vw;
    width: 25vw;
    height: 25vw;
    transform-origin: left 12.5vw;
    animation: rotate-circle-right 0.5s linear 1.65s forwards;
}

.navy01::after {
    top: 0;
    left: -12.5vw;
    width: 25vw;
    height: 25vw;
    transform-origin: right 12.5vw;
    animation: rotate-circle-left 0.5s linear 1.4s forwards;
}

.navy00 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 9vw;
    height: 9vw;
    z-index: 4;
}

/*==============
yellow circle
==============*/

.yellow02 {
    top: -200%;
    animation-delay: 1.45s;
}

.yellow01 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(20deg);
    width: 23vw;
    height: 23vw;
    background: #ffe08b;
    z-index: 1;
}

.yellow01::before {
    top: 0;
    left: 11.5vw;
    width: 23vw;
    height: 23vw;
    transform-origin: left 11.5vw;
    animation: rotate-circle-right 0.5s linear 1.7s forwards;
}

.yellow01::after {
    top: 0;
    left: -11.5vw;
    width: 23vw;
    height: 23vw;
    transform-origin: right 11.5vw;
    animation: rotate-circle-left 0.5s linear 1.45s forwards;
}

.yellow00 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 9vw;
    height: 9vw;
    z-index: 4;
}

/*==============
blue circle
==============*/

.blue02 {
    top: -300%;
    animation-delay: 1.2s;
}

.blue01 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(20deg);
    width: 16vw;
    height: 16vw;
    background: #457ed4;
    z-index: 1;
}

.blue01::before {
    top: 0;
    left: 8vw;
    width: 16vw;
    height: 16vw;
    transform-origin: left 8vw;
    animation: rotate-circle-right 0.5s linear 1.45s forwards;
}

.blue01::after {
    top: 0;
    left: -8vw;
    width: 16vw;
    height: 16vw;
    transform-origin: right 8vw;
    animation: rotate-circle-left 0.5s linear 1.2s forwards;
}

.blue00 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 7vw;
    height: 7vw;
    z-index: 4;
}

/*==============
red circle
==============*/

.red02 {
    top: -400%;
    animation-delay: 1.3s;
}

.red01 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    width: 12vw;
    height: 12vw;
    background: #e8595f;
    z-index: 1;
}

.red01::before {
    top: 0;
    left: 6vw;
    width: 12vw;
    height: 12vw;
    transform-origin: left 6vw;
    animation: rotate-circle-right 0.5s linear 1.55s forwards;
}

.red01::after {
    top: 0;
    left: -6vw;
    width: 12vw;
    height: 12vw;
    transform-origin: right 6vw;
    animation: rotate-circle-left 0.5s linear 1.3s forwards;
}

.red00 {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 9vw;
    height: 9vw;
    z-index: 4;
}

@keyframes animation05_double {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes rotate-circle-left {
    0% {
        background: #f2f3df;
        transform: rotate(0deg);
    }
    50% {
        background: #f2f3df;
        transform: rotate(-180deg);
    }
    50.01% {
        background: #f2f3df;
        transform: rotate(-180deg);
    }
    100% {
        background: #f2f3df;
        transform: rotate(-360deg);
    }
}

@keyframes rotate-circle-right {
    0% {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(-180deg);
    }
    100% {
        transform: rotate(-360deg);
    }
}

/*===================
animation06
====================*/

.animation06 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    height: 100%;
}

.rhombus05 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    animation: rhombus 0.7s ease-in 0.3s forwards;
    /* animation: rhombus 0.7s ease-in 2.0s forwards; */

    opacity: 0;
}

.rhombus04 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(45deg);
    width: 50vw;
    height: 50vw;
    background-color: #ef5958;
}

.rhombus03 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 37.5vw;
    height: 37.5vw;
    background-color: #77ceb9;
}

.rhombus02 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 25vw;
    height: 25vw;
    background-color: #ffe08b;
}

.rhombus01 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12.25vw;
    height: 12.25vw;
    background-color: #fff;
}

@keyframes rhombus {
    0% {
        transform: scale3d(0, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(10, 10, 1);
        opacity: 1;
    }
}

/*===================
animation07
====================*/

.animation07 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 2.5vw;
    height: 2.5vw;
}

.animation07 .circle {
    position: absolute;
    top: -.2vw;
    left: -.2vw;
    transform-origin: center;
    width: 2.5vw;
    height: 2.5vw;
    animation: animation07_circle 0.2s ease-in 2.19s forwards;
}

.animation07 .circle_element01 {
    position: absolute;
    top: 0;
    left: 0;
    width: 2.5vw;
    height: 2.5vw;
    border: 0.2vw solid #a18a66;
    background-color: #fff;
    border-radius: 50%;
    animation: animation07_circle_element01 0.2s ease-in 2.0s forwards;
    transform-origin: center;
    opacity: 0;
}

@keyframes animation07_circle {
    0% {
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(1.4, 1.4, 1);
        opacity: 0;
    }
}

@keyframes animation07_circle_element01 {
    0% {
        transform: scale3d(0, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

.animation07 .line_wrapper {
    position: absolute;
    opacity: 0;
}

.animation07 .line {
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #a18a66;
}

/*===========
line01
===========*/

.animation07 .line_wrapper01 {
    top: -95%;
    left: 45%;
    width: 10%;
    height: 60%;
    animation: animation07_line_wrapper01 0.5s ease-in 2.0s forwards;
}

.animation07 .line01 {
    animation: animation07_line01 0.5s ease-in 1.6s forwards;
}

/*===========
line02
===========*/

.animation07 .rotate60 {
    display: block;
    position: absolute;
    top: 22.5%;
    left: 33%;
    width: 100%;
    height: 100%;
    transform: rotate(60deg);
}

.animation07 .line_wrapper02 {
    top: -78%;
    left: 10%;
    width: 10%;
    height: 60%;
    animation: animation07_line_wrapper01 0.5s ease-in 2.0s forwards;
}

.animation07 .line02 {
    animation: animation07_line01 0.5s ease-in 1.6s forwards;
}

/*===========
line03
===========*/

.animation07 .rotate120 {
    display: block;
    position: absolute;
    top: 36.5%;
    left: 0%;
    width: 100%;
    height: 100%;
    transform: rotate(120deg);
}

.animation07 .line_wrapper03 {
    top: -78%;
    left: 10%;
    width: 10%;
    height: 60%;
    animation: animation07_line_wrapper01 0.5s ease-in 2.0s forwards;
}

.animation07 .line03 {
    animation: animation07_line01 0.5s ease-in 1.6s forwards;
}

/*===========
line04
===========*/

.animation07 .line_wrapper04 {
    top: 140%;
    left: 45%;
    width: 10%;
    height: 60%;
    animation: animation07_line_wrapper02 0.5s ease-in 2.0s forwards;
}

.animation07 .line04 {
    animation: animation07_line02 0.5s ease-in 1.6s forwards;
}

/*===========
line05
===========*/

.animation07 .rotate-120 {
    display: block;
    position: absolute;
    top: -15.5%;
    left: -34%;
    width: 100%;
    height: 100%;
    transform: rotate(-120deg);
}

.animation07 .line_wrapper05 {
    top: -78%;
    left: 10%;
    width: 10%;
    height: 60%;
    animation: animation07_line_wrapper01 0.5s ease-in 2.0s forwards;
}

.animation07 .line05 {
    animation: animation07_line01 0.5s ease-in 1.6s forwards;
}

/*===========
line06
===========*/

.animation07 .rotate-60 {
    display: block;
    position: absolute;
    top: -34.5%;
    left: -3%;
    width: 100%;
    height: 100%;
    transform: rotate(-60deg);
}

.animation07 .line_wrapper06 {
    top: -78%;
    left: 10%;
    width: 10%;
    height: 60%;
    animation: animation07_line_wrapper01 0.5s ease-in 2.0s forwards;
}

.animation07 .line06 {
    animation: animation07_line01 0.5s ease-in 1.6s forwards;
}

@keyframes animation07_line_wrapper01 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation07_line01 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

@keyframes animation07_line_wrapper02 {
    0% {
        transform-origin: bottom;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
    100% {
        transform-origin: bottom;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
}

@keyframes animation07_line02 {
    0% {
        transform-origin: top;
        transform: scale3d(1, 0, 1);
        opacity: 1;
    }
    100% {
        transform-origin: top;
        transform: scale3d(1, 1, 1);
        opacity: 1;
    }
}

/*===================
animation08
====================*/

.animation08 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    animation: animation08 1.5s ease-out 2.8s forwards;
    opacity: 0;
}

.animation08 div:nth-of-type(1) {
    width: 100%;
    height: 100%;
    background: #fff;
}

.animation08 div:nth-of-type(2) {
    width: 100%;
    height: 25%;
    background: #75cfb9;
}

.animation08 div:nth-of-type(3) {
    width: 100%;
    height: 25%;
    background: #457ed4;
}

.animation08 div:nth-of-type(4) {
    width: 100%;
    height: 25%;
    background: #e8595f;
}

.animation08 div:nth-of-type(5) {
    width: 100%;
    height: 25%;
    background: #ffe08b;
}

@keyframes animation08 {
    0% {
        transform: translateY(-200vh);
        opacity: 1;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

@media screen and (max-width: 750px) {
/*===================
animation02
====================*/
@keyframes animation02 {
    0% {
        transform: scale3d(0, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(1.2, 1.2, 1);
        opacity: 1;
    }
}
/*==============
green circle
==============*/
.green01 {
    width: 70vw;
    height: 70vw;
}
.green01::before {
    left: 35vw;
    width: 70vw;
    height: 70vw;
    transform-origin: left 35vw;
}
.green01::after {
    left: -35vw;
    width: 70vw;
    height: 70vw;
    transform-origin: right 35vw;
}
/*==============
navy circle
==============*/
.navy01 {
    width: 50vw;
    height: 50vw;
}
.navy01::before {
    left: 25vw;
    width: 50vw;
    height: 50vw;
    transform-origin: left 25vw;
}
.navy01::after {
    left: -25vw;
    width: 50vw;
    height: 50vw;
    transform-origin: right 25vw;
}
/*==============
yellow circle
==============*/
.yellow01 {
    width: 35vw;
    height: 35vw;
}
.yellow01::before {
    left: 17.5vw;
    width: 35vw;
    height: 35vw;
    transform-origin: left 17.5vw;
}
.yellow01::after {
    left: -17.5vw;
    width: 35vw;
    height: 35vw;
    transform-origin: right 17.5vw;
}
/*==============
blue circle
==============*/
.blue01 {
    width: 20vw;
    height: 20vw;
}
.blue01::before {
    left: 10vw;
    width: 20vw;
    height: 20vw;
    transform-origin: left 10vw;
}
.blue01::after {
    left: -10vw;
    width: 20vw;
    height: 20vw;
    transform-origin: right 10vw;
}
.blue00 {
    width: 7vw;
    height: 7vw;
}
/*==============
red circle
==============*/
.red00 {
    width: 6vw;
    height: 6vw;
}
/*===================
animation06
====================*/
@keyframes rhombus {
    0% {
        transform: scale3d(0, 0, 1);
        opacity: 1;
    }
    100% {
        transform: scale3d(20, 20, 1);
        opacity: 1;
    }
}
}




</style>
    <!-- <div class="row ml-1" > -->

    <?php 
    $ix = 0; 
    $viii = 0;
    $vii = 0;
    $vi = 0;
    $v = 0;
    $iv = 0;
    $iii = 0;
    $ii = 0;
    $i = 0;
    $nilaix = 0;
    $nilaiy = 0;
    $talenta9 = 0;
    $talenta8 = 0;
    $talenta7 = 0;
    $talenta6 = 0;
    $talenta5 = 0;
    $talenta4 = 0;
    $talenta3 = 0;
    $talenta2 = 0;
    $talenta1 = 0;
    $data['talenta'] = null;
    if($result){

    
    foreach($result as $rs){ 
        // $data['talenta'][10][$rs->id_peg]['jumlah'] = 0;
        //   $nilaiy = floatval($rs->res_potensial_cerdas) + floatval($rs->res_potensial_rj) + floatval($rs->res_potensial_lainnya);
        //   $nilaix = $rs->res_kinerja;
        // dd($rs);
        //  if($rs->res_kinerja > 0) {
          $nilaiy = $rs->res_kinerja;
          $nilaix = floatval($rs->res_potensial_cerdas) + floatval($rs->res_potensial_rj) + floatval($rs->res_potensial_lainnya);
          if($nilaiy == null){
            $nilaiy = 0;
          }  
          if($nilaix == null){
            $nilaix = 0;
          }  
          
          if($nilaix >= $tinggi['dari'] && $nilaiy >= $diatasekspektasi['dari']) {
              $data['talenta'][9][$rs->id_pegawai] = 0;
              $ix++;
              
             } 
             if($nilaix >= $tinggi['dari'] && $nilaiy >= $sesuaiekspektasi['dari'] && $nilaiy < $diatasekspektasi['dari']) {
             $data['talenta'][8][$rs->id_pegawai] = 0;
              $viii++;
             }
             if($nilaix >= $menengah['dari'] && $nilaix < $tinggi['dari'] && $nilaiy >= $diatasekspektasi['dari']) {
             $data['talenta'][7][$rs->id_pegawai] = 0;
              $vii++;
             } 
            if($nilaix >= $tinggi['dari'] && $nilaiy < $sesuaiekspektasi['dari']) {
             $data['talenta'][6][$rs->id_pegawai] = 0;
              $vi++;
             } 
             if($nilaix >= $menengah['dari'] && $nilaix < $tinggi['dari'] && $nilaiy >= $sesuaiekspektasi['dari'] && $nilaiy < $diatasekspektasi['dari']) {
             $data['talenta'][5][$rs->id_pegawai] = 0;
              $v++;
            } 
            if($nilaix < $menengah['dari'] && $nilaiy >= $diatasekspektasi['dari']) {
             $data['talenta'][4][$rs->id_pegawai] = 0;
              $iv++;
            } 
            if($nilaix >= $menengah['dari'] && $nilaix < $tinggi['dari'] && $nilaiy < $sesuaiekspektasi['dari']) {
             $data['talenta'][3][$rs->id_pegawai] = 0;
              $iii++;
            }
            if($nilaix < $menengah['dari'] && $nilaiy >= $sesuaiekspektasi['dari'] && $nilaiy < $diatasekspektasi['dari']) {
              $data['talenta'][2][$rs->id_pegawai] = 0;
              $ii++;
            }
            if($nilaix < $menengah['dari'] && $nilaiy < $sesuaiekspektasi['dari']) {
             $data['talenta'][1][$rs->id_pegawai] = 0;
          
             $i++;
            }  
			// }
            }
            // dd($data['talenta'][9]);
            // dd($ix);

        // foreach($result as $a){
        //     if(isset($data['talenta'][9])){
        //     $data['talenta'][9][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][8])){
        //     $data['talenta'][8][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][7])){
        //         $data['talenta'][7][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][6])){
        //         $data['talenta'][6][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][5])){
        //         $data['talenta'][5][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][4])){
        //         $data['talenta'][4][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][3])){
        //         $data['talenta'][3][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][2])){
        //         $data['talenta'][2][$a->id_peg]['jumlah']++;
        //     }
        //     if(isset($data['talenta'][1])){
        //         $data['talenta'][1][$a->id_peg]['jumlah']++;
        //     }
            
        // }
        
        if(isset($data['talenta'][9])){
            $talenta9 = count($data['talenta'][9]);
        } 
        if(isset($data['talenta'][8])){
            $talenta8 = count($data['talenta'][8]);
        }
        if(isset($data['talenta'][7])){
            $talenta7 = count($data['talenta'][7]);
        } 
        if(isset($data['talenta'][6])){
            $talenta6 = count($data['talenta'][6]);
        } 
        if(isset($data['talenta'][5])){
            $talenta5 = count($data['talenta'][5]);
        } 
        if(isset($data['talenta'][4])){
            $talenta4 = count($data['talenta'][4]);
        } 
        if(isset($data['talenta'][3])){
            $talenta3 = count($data['talenta'][3]);
        } 
        if(isset($data['talenta'][2])){
            $talenta2 = count($data['talenta'][2]);
        } 
        if(isset($data['talenta'][1])){
            $talenta1 = count($data['talenta'][1]);
        }  

            // dd($i);
        }?>
    <div class="card card-default" style="background-color:#2e4963;">
      <div class="row" >
      <div class="col-lg-3" >
      <div class="card-body">
      <form  action="<?=base_url('simata/C_Simata/nineBox/'.$jenis_pengisian.'')?>" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Jenis Penjenjangan Jabatan</label>
        <select class="form-select select2" name="jenis_jabatan" id="jenis_jabatan"  required>
        <option value=""  selected>Pilih Jenis Jabatan</option>
        <?php if($jenis_pengisian == 1) { ?>
            <option <?php if($post) { if($post['jenis_jabatan'] == 4) echo "selected"; else echo "";}?> value="4">Pelaksana</option>
            <option <?php if($post) { if($post['jenis_jabatan'] == 3) echo "selected"; else echo "";}?> value="3">Pengawas</option>
        <?php } ?>
        <?php if($jenis_pengisian == 2) { ?>
            <option <?php if($post) { if($post['jenis_jabatan'] == 1) echo "selected"; else echo "";}?> value="1">Administrator</option>
            <option <?php if($post) { if($post['jenis_jabatan'] == 3) echo "selected"; else echo "";}?> value="3">Pengawas</option>

        <?php } ?>
        <?php if($jenis_pengisian == 3) { ?>
            <option <?php if($post) { if($post['jenis_jabatan'] == 2) echo "selected"; else echo "";}?> value="2">JPT</option>
            <option <?php if($post) { if($post['jenis_jabatan'] == 1) echo "selected"; else echo "";}?> value="1">Administrator</option>

        <?php } ?>

        

      </select>
      </div>
      <!-- <div class="mb-3" style='<?php if($post) { if($post['jenis_jabatan'] == 1) echo ""; else echo "display:none";} else echo "display:none";?>' id="adm">
        <label for="exampleInputPassword1" class="form-label">Jabatan Target</label>
        <select class="form-select select2" name="jabatan_target_adm" >
                <option value=""  selected>Semua</option>
                    <?php if($jabatan_target_adm){ foreach($jabatan_target_adm as $r){ ?>
                     <option <?php if($jt_adm) { if($jt_adm == $r['id_jabatanpeg']) echo "selected"; else echo "";}?> value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
                </select>
      </div>
       -->
       <?php if($this->general_library->isProgrammer()) { ?>
      <div class="mb-3"  id="jpt" style="display:none">
        <label for="exampleInputPassword1" class="form-label">Jabatan Target</label>
        <select class="form-select select2" name="jabatan_target_jpt" >
                <option value=""  selected>Semua</option>
                    <?php if($jabatan_target_jpt){ foreach($jabatan_target_jpt as $r){ ?>
                     <option <?php if($jt_jpt) { if($jt_jpt == $r['id_jabatanpeg']) echo "selected"; else echo "";}?> value="<?=$r['id_jabatanpeg']?>"><?=$r['nama_jabatan']?></option>
                    <?php } } ?>
                </select>
      </div>
      <?php }  ?>

      <button type="submit" class="btn btn-primary float-right mb-2">Lihat</button>
    </form>
     </div>
    </div>
      <div class="col-lg-6" style="background-color:#fff;">
      <?php if(!$post) { ?>
      <!-- animasi -->  
    <div class="cardz">
    
    <div class="animation06">
        <div class="rhombus05">
            <div class="rhombus04">
                <div class="rhombus03">
                    <div class="rhombus02">
                        <div class="rhombus01"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    </div>
<!-- animasi -->
<?php } ?>
        <div class="card-body" >
   
        <?php if($post) { ?>
        <table class=" table-bordered" border="1" style="width:100%;margin-left:-30px;background-color:rgba(0, 0, 0, 0);color:#fff">
       <tr>
        <td></td>
        <td></td>
        <td style="color: rgba(0, 0, 0, 0);" class="text-center" colspan="3"></td>
        <td></td>
      
      </tr>
      <tr style="color: rgba(0, 0, 0, 0);">
        <td></td>
        <td style="background-color:#2e4963;"></td>
        <td style="background-color:#2e4963;">1</td>
        <td style="background-color:#2e4963;">2</td>
        <td style="background-color:#2e4963;">3</td>
        <td style="background-color:#2e4963;"></td>
      </tr>


      <tr>
        <td  rowspan="3">
        <span class="vertical-rl rotated" style="font-size:20px;height:16%;color:#2e4963;">KINERJA</span>

        </td>
        <td style="background-color:#2e4963;color:#fff">
        <span class="vertical-rl rotated" style="font-size:9px;height:16%"><b>Di Atas Ekspektasi</b></span>
        </td>
        <td rowspan="3" colspan="3">
        <div class="parent">
        <div class="div4">
        <canvas id="myChart4" style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div7">
        <canvas id="myChart7" style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div9">
        <canvas id="myChart9" style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div2">
        <canvas id="myChart2" style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div5">
        <canvas id="myChart5" style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div8">
        <canvas id="myChart8" style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div1">
        <canvas id="myChart"  style="height:100%; width:11vw;"></canvas>
        </div>
        <div class="div3">
        <canvas id="myChart3" style="height:100%; width:11vw;"></canvas>
        </div>
        <a href=""></a>
        <div class="div6">
        <canvas id="myChart6" style="height:100%; width:11vw;"></canvas>
        </div>
        </div>
        </td>
        <td style="background-color:#2e4963;color:#fff"></td>
        <td style="color: rgba(0, 0, 0, 0);" rowspan="3">
        <span class="vertical-rl rotated" style="font-size:9px;height:15%">ddd</span>
        </td>
      </tr>
      <tr>
        <td  style="font-size:10px;height:30%;background-color:#2e4963;color:#fff">
        <span class="vertical-rl rotated" style="font-size:9px;height:16%"><b>Sesuai Ekspektasi</b></span>
    
    </td>
       <td style="color: rgba(0, 0, 0, 0);background-color:#2e4963;">
       <span class="vertical-rl rotated" style="font-size:10px;height:16%">bbbb</span>
       </td>
      </tr>
      <tr>
        <td style="font-size:10px;height:30%;background-color:#2e4963;color:#fff">
        <span class="vertical-rl rotated" style="font-size:9px;height:16%;"><b>Di Bawah Ekspektasi</b></span>
    
    </td>
       <td style="color: rgba(0, 0, 0, 0);background-color:#2e4963;">
       <span class="vertical-rl rotated" style="font-size:10px;height:16%">cccc</span>
       </td>
      </tr>
      <tr>
        <td></td>
        <td style="background-color:#2e4963;color:#000"></td>
        <td class="text-center" style="font-size:9px;width:30%;background-color:#2e4963;color:#fff"><b>Rendah</b></td>
        <td class="text-center" style="font-size:9px;width:30%;background-color:#2e4963;color:#fff"><b>Menengah</b></td>
        <td class="text-center" style="font-size:9px;width:30%;background-color:#2e4963;color:#fff"><b>Tinggi</b>  </td>
       <td style="background-color:#2e4963;color:#000"></td>
       <td></td>
      </tr>


      
      <tr>
        <td></td>
        <td></td>
        <td class="text-center" colspan="3" style="font-size:20px;color:#2e4963">POTENSIAL</td>
        <td></td>
        <td></td>
      </tr>
    </table>
    <?php } ?>
        </div>
    </div>
    <div class="col-lg-3" >
    <div class="card-body" >
    <table class="table table-bordered" border="1" style="width:110%;margin-left:-20px;color:#fff;">
    <thead>
      <tr>
        <th valign="top" class="text-center">Kotak</th>
        <th class="text-center">Jumlah Talenta </th>
      </tr>



      </thead>
      <tbody>
      <tr class="text-center" style="background-color: #1cbb8c">
      <td >IX  </td>
      <td ><?=$talenta9;?></td>
      <td>
        <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="9" data-jumlah="<?=$ix;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
        </td>
      </tr>
      <tr class="text-center" style="background-color: #1cbb8c">
      <td>VIII</td>
      <td><?=$talenta8;?></td>
      <td>
      <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="8" data-jumlah="<?=$viii;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
    </td>
      </tr>
      <tr class="text-center" style="background-color: #1cbb8c">
      <td>VII</td>
      <td><?=$talenta7;?></td>
      <td>
      <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="7" data-jumlah="<?=$vii;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
    </td>
      </tr>
      <tr class="text-center" style="background-color: #fcb92c">
      <td>VI</td>
      <td><?=$talenta6;?></td>
      <td>
      <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="6" data-jumlah="<?=$vi;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
    </td>
      </tr>
      <tr class="text-center" style="background-color: #fcb92c">
      <td>V</td>
      <td><?=$talenta5;?></td>
      <td>
      <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="5" data-jumlah="<?=$v;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
    </td>

      </tr>
      <tr class="text-center" style="background-color: #fcb92c">
      <td>IV</td>
      <td><?=$talenta4;?></td>
           <td>
           <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="4" data-jumlah="<?=$iv;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
        </td>
      </tr>
      <tr class="text-center" style="background-color: #be4d4d">
      <td>III</td>
      <td><?=$talenta3;?></td>
           <td>
           <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="3" data-jumlah="<?=$iii;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
        </td>
      </tr>
      <tr class="text-center" style="background-color: #be4d4d">
      <td>II</td>
      <td><?=$talenta2;?></td>
           <td>
           <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="2" data-jumlah="<?=$ii;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
        </td>
      </tr>
      <tr class="text-center" style="background-color: #be4d4d">
      <td>I</td>
      <td><?=$talenta1;?></td>
           <td>
           <?php if($post) { ?>
        <button style="border-radius:8px;" data-box="1" data-jumlah="<?=$i;?>" class="open-DetailNinebox btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_detail"><i class="fa fa-search"></i></button>
        <?php } ?>
        </td>
      </tr>
      </tbody>
      </table>
    </div>
    </div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail_nine_box">
        ...
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
<!-- tutup modal  -->


<?php if($post) { ?>
<input type="hidden" name="jenis_jab" id="jenis_jab" value="<?=$post['jenis_jabatan'];?>">
<?php if($jt_jpt) { ?>
<input type="hidden" name="jt" id="jt" value="<?=$jt_jpt;?>">
<?php }  else { ?> 
<input type="hidden" name="jt" id="jt" value="0">
<?php } ?>
<?php } ?>

<!-- </div> -->
<?php $nilai['result'] = $result;?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<script>

$(function(){          
    // loadChartNineBox()
    $(".select2").select2({   
		width: '100%',
		// dropdownAutoWidth: true,
		allowClear: true
	});
  })

  $(document).on("click", ".open-DetailNinebox", function () {
    var jenis_jab = $('#jenis_jab').val()
    var jt = $('#jt').val()
    var box = $(this).data('box');
    var jumlah = $(this).data('jumlah');
    var jenis_pengisian = "<?=$jenis_pengisian;?>"

        $('#detail_nine_box').html('')
        $('#detail_nine_box').append(divLoaderNavy)
        $('#detail_nine_box').load('<?=base_url("simata/C_Simata/loadDetailNineBox/")?>'+jenis_jab+'/'+jt+'/'+box+'/'+jumlah+'/'+jenis_pengisian, function(){
        $('#loader').hide()
        })

        });

  function loadChartNineBox(){
   $('#div_chart').html('')
   $('#div_chart').append(divLoaderNavy)
   $('#div_chart').load('<?=base_url("simata/C_Simata/loadChartNineBox/")?>', function(){
     $('#loader').hide()
   })
 }

//  $('#jenis_jabatan').on('change', function() {
//   if(this.value == 1) {
//    $('#adm').show('fast')
//    $('#jpt').hide()
//   } else {
//     $('#jpt').show('fast')
//     $('#adm').hide()
//   }
// });

    
    var dx = JSON.parse('<?=json_encode($nilai)?>');
    var c = [];
    let point = [];
    let point2 = [];
    let point3 = [];
    let point4 = [];
    let point5 = [];
    let point6 = [];
    let point7 = [];
    let point8 = [];
    let point9 = [];

    
    let temp = Object.keys(dx.result)
    temp.forEach((i) => {
        //   let nilaiy = parseFloat(dx.result[i].res_potensial_cerdas) + parseFloat(dx.result[i].res_potensial_rj) + parseFloat(dx.result[i].res_potensial_lainnya);
        //   let nilaix = parseFloat(dx.result[i].res_kinerja)
          let nilaix = dx.result[i].res_potensial_total;
          let nilaiy = dx.result[i].res_kinerja;
          console.log(dx.result);
         
          if(nilaix == null){
            nilaix = 0;
          }
          if(nilaiy == null){
            nilaiy = 0;
          }

        //   if(nilaiy > 0) {
          if(nilaix < <?=$menengah['dari'];?> && nilaiy < <?=$sesuaiekspektasi['dari'];?>) {
            point.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix < <?=$menengah['dari'];?> && nilaiy >= <?=$sesuaiekspektasi['dari'];?> && nilaiy < <?=$diatasekspektasi['dari'];?>) {
            point2.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix >= <?=$menengah['dari'];?> && nilaix < <?=$tinggi['dari'];?> && nilaiy < <?=$sesuaiekspektasi['dari'];?>) {
            point3.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix < <?=$menengah['dari'];?> && nilaiy >= <?=$diatasekspektasi['dari'];?>) {
            point4.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix >= <?=$menengah['dari'];?> && nilaix < <?=$tinggi['dari'];?> && nilaiy >= <?=$sesuaiekspektasi['dari'];?> && nilaiy < <?=$diatasekspektasi['dari'];?>) {
            point5.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix >= <?=$tinggi['dari'];?> && nilaiy < <?=$sesuaiekspektasi['dari'];?>) {
            point6.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix >= <?=$menengah['dari'];?> && nilaix < <?=$tinggi['dari'];?> && nilaiy >= <?=$diatasekspektasi['dari'];?>) {
            point7.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix >= <?=$tinggi['dari'];?> && nilaiy >= <?=$sesuaiekspektasi['dari'];?> && nilaiy < <?=$diatasekspektasi['dari'];?>) {
            point8.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
          if(nilaix >= <?=$tinggi['dari'];?> && nilaiy >= <?=$diatasekspektasi['dari'];?>) {
            point9.push({ x: nilaix, y: nilaiy, nama:dx.result[i].nama })
          }
        // }
    });
  

    var data1 = point;
    var data2 = point2;
    var data3 = point3; 
    var data4 = point4;
    var data5 = point5;
    var data6 = point6;
    var data7 = point7;
    var data8 = point8;
    var data9 = point9;

    
    var pointcolor = ['Cornsilk', 'DarkMagenta', 'DeepPink', 'MediumSlateBlue', 'NavajoWhite', 'lightblue'];
    var pointsize = 3;
    // var pointcolor = "#000";
    
const data = {
datasets: [{
  // label : 'tes',
  data: data1,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize ,
      pointHoverRadius: 2,  
      borderWidth: 1
}],

};

const nineGridLabels = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('I', x.getPixelForValue(35), y.getPixelForValue(30)) 
  }) 
}


const tooltipchart = {
       
        callbacks:{
            
          label: (context) => {
            // console.log(context)
            // return `Nama new line Pegawai - x: ${context.raw.x} and y: ${context.raw.y}`;
            // return ["Kinerja: "+context.raw.x, "Potensial: "+context.raw.y, context.raw.nama];
            return ["Kinerja: "+context.raw.y, "Potensial: "+context.raw.x];
            
          },
          labelColor: function(context) {
                        return {
                            borderColor: 'rgb(0, 0, 255)',
                            // backgroundColor: 'rgb(255, 0, 0)',
                            backgroundColor:  ['Cornsilk'],
                           
                            borderWidth: 1,
                            // borderDash: [1, 1],
                            borderRadius: 1,
                        };
                    },
          // labelTextColor: function(context) {
          // return '#543453';
          // }
        }   
}

const config = {
type: 'scatter',
data,
options: {
  plugins: {
      legend: {
          display: false
      }, 
      tooltip: tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$rendah['dari'];?>,
     max: <?=$rendah['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     }

    },
    y: {
     min: <?=$dibawahekspektasi['dari'];?>,
     max: <?=$dibawahekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels]
};

// function renderChart(){  
const myChart = new Chart(
document.getElementById('myChart'),
config
);
// }


</script>

<!-- dua  -->
<script>
const nineGridLabels2 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('II', x.getPixelForValue(35), y.getPixelForValue(77)) 
  }) 
}

const config2 = {
type: 'scatter',
data: {datasets: [{
  data: data2,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$rendah['dari'];?>,
     max: <?=$rendah['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$sesuaiekspektasi['dari'];?>,
     max: <?=$sesuaiekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels2]
};

const myChart2 = new Chart(
document.getElementById('myChart2'),
config2
);
</script>



<script>
const nineGridLabels3 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('III', x.getPixelForValue(<?=$label_menengah;?>), y.getPixelForValue(30)) 
  }) 
}

const config3 = {
type: 'scatter',
data: {datasets: [{
  data: data3,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$menengah['dari'];?>,
     max: <?=$menengah['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$dibawahekspektasi['dari'];?>,
     max: <?=$dibawahekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels3]
};

const myChart3 = new Chart(
document.getElementById('myChart3'),
config3
);
</script>


<!-- empat -->
<script>
const nineGridLabels4 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('IV', x.getPixelForValue(35), y.getPixelForValue(92)) 
  }) 
}

const config4 = {
type: 'scatter',
data: {datasets: [{
  data: data4,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$rendah['dari'];?>,
     max: <?=$rendah['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$diatasekspektasi['dari'];?> ,
     max: <?=$diatasekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels4]
};

const myChart4 = new Chart(
document.getElementById('myChart4'),
config4
);
</script>



<!-- lima -->
<script>
const nineGridLabels5 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('V', x.getPixelForValue(<?=$label_menengah;?>), y.getPixelForValue(77)) 
  }) 
}

const config5 = {
type: 'scatter',
data: {datasets: [{
  data: data5,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$menengah['dari'];?>,
     max: <?=$menengah['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$sesuaiekspektasi['dari'];?>,
     max: <?=$sesuaiekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels5]
};

const myChart5 = new Chart(
document.getElementById('myChart5'),
config5
);
</script>



<!-- enam -->
<script>
const nineGridLabels6 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('VI', x.getPixelForValue(<?=$label_tinggi;?>), y.getPixelForValue(31)) 
  }) 
}

const config6 = {
type: 'scatter',
data: {datasets: [{
  data: data6,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$tinggi['dari'];?>,
     max: <?=$tinggi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$dibawahekspektasi['dari'];?>,
     max: <?=$dibawahekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels6]
};

const myChart6 = new Chart(
document.getElementById('myChart6'),
config6
);
</script>



<!-- tujuh -->
<script>
const nineGridLabels7 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('VII', x.getPixelForValue(<?=$label_menengah;?>), y.getPixelForValue(92)) 
  }) 
}

const config7 = {
type: 'scatter',
data: {datasets: [{
  data: data7,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$menengah['dari'];?>,
     max: <?=$menengah['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$diatasekspektasi['dari'];?>,
     max: <?=$diatasekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels7]
};

const myChart7 = new Chart(
document.getElementById('myChart7'),
config7
);
</script>



<!-- delapan -->
<script>
const nineGridLabels8 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('VIII', x.getPixelForValue(<?=$label_tinggi;?>), y.getPixelForValue(77)) 
  }) 
}

const config8 = {
type: 'scatter',
data: {datasets: [{
  data: data8,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      // pointBackgroundColor: ['yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'],
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$tinggi['dari'];?>,
     max: <?=$tinggi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$sesuaiekspektasi['dari'];?>,
     max: <?=$sesuaiekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels8   ]
};

const myChart8 = new Chart(
document.getElementById('myChart8'),
config8
);
</script>



<!-- sembilan -->
<script>
const nineGridLabels9 = {
  id: 'nineGridLabels',
  beforeDatasetsDraw: ((chart, args, plugins) => {
   const { ctx, 
      chartArea: { top, bottom, left, right}, 
      scales:
   {x, y}} = chart;

   ctx.save();
   ctx.font = 'bold 18px sans-serif';
   ctx.fillStyle = "#fff";
   ctx.backgroundColor = "#dc3545",
   ctx.borderColor = "#dc3545",
   ctx.textAlign = 'center';
      ctx.fillText('IX', x.getPixelForValue(<?=$label_tinggi;?>), y.getPixelForValue(92)) 
  }) 
}

const config9 = {
type: 'scatter',
data: {datasets: [{
  data: data9,
      fill: true,
      borderColor: "#dc3545",
      backgroundColor: "#dc3545",
      pointBackgroundColor: pointcolor,
      pointBorderColor: "#000",
      pointRadius: pointsize,
      pointHoverRadius: 2,  
      borderWidth: 1
}]},
options: {
  plugins: {
      legend: {
          display: false
      },
      tooltip:tooltipchart
  },
  
  aspectRatio : false   ,
  scales: {
  x: {
     min: <?=$tinggi['dari'];?>,
     max: <?=$tinggi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },

    },
    y: {
     min: <?=$diatasekspektasi['dari'];?>,
     max: <?=$diatasekspektasi['sampai'];?>,
     afterTickToLabelConversion: (ctx) => {
      // console.log(ctx)
      ctx.ticks = [];
     },
     grid: {
      drawTicks: false
     },
     border: {
      width: 0
     },
    }
  }
},
plugins: [nineGridLabels9]
};

const myChart9 = new Chart(
document.getElementById('myChart9'),
config9
);
</script>