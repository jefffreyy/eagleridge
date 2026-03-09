<?php $this->load->view('templates/css_link'); ?>


<html>
<style>
  * {
    
  }

  .keyboard {
    display: grid;
    grid-template-columns: repeat(10, 1fr);
    gap: 5px;
    padding: 10px;
  }

  .key {

    height: 50px;
    text-align: center;
    line-height: 40px;
    cursor: pointer;
  }

  .keybox {

    background-color: #ffffff;
  }

  .keyboard_number {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 5px;
    padding: 10px;
  }

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0;
  }

  .cursor-line {
    position: absolute;
    background-color: #000;
    width: 1px;
    height: 25px;
    animation: cursor-blink 0.8s infinite;
    display: none;
  }

  @keyframes cursor-blink {

    0%,
    100% {
      opacity: 0;
    }

    50% {
      opacity: 1;
    }
  }
</style>

<body style="overflow: hidden; height: 100%; width: 100%; overscroll-behavior: none;" ontouchmove="BlockMove(event);">

  <div style="width: 1920px; height: 1080px; position: relative">
    <div style="width: 1920px; height: 350px; left: 0px; top: 730px; position: absolute; background: #B8CBE9"></div>
    <div style="width: 640px; height: 70px; left: 375px; top: 910px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
            <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Z</div>
          </div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">X</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">C</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">V</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">B</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">N</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">M</div>
        </div>
      </div>
    </div>

    <div style="width: 640px; height: 70px; left: 375px; top: 991px; position: absolute">
      <div style="width: 640px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
            <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
          </div>
        </div>
      </div>

      <div style="width: 640px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
            <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
          </div>
        </div>
      </div>
    </div>

    <div style="width: 826px; height: 70px; left: 282px; top: 829px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
            <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">A</div>
          </div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">S</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">D</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">F</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">G</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">H</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">J</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 651px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">K</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 744px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">L</div>
        </div>
      </div>
    </div>

    <div style="width: 919px; height: 70px; left: 235px; top: 748px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Q</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">W</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">E</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">R</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">T</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Y</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">U</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 651px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">I</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 744px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">O</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 837px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">P</div>
        </div>
      </div>
    </div>

    <div style="width: 268px; height: 70px; left: 1184px; top: 829px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">4</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">5</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">6</div>
        </div>
      </div>
    </div>

    <div style="width: 268px; height: 70px; left: 1184px; top: 910px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">1</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">2</div>
        </div>
      </div>
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">3</div>
        </div>
      </div>
    </div>

    <div style="width: 175px; height: 70px; left: 1184px; top: 991px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">.</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">0</div>
        </div>
      </div>
    </div>

    <div style="width: 203px; padding-top: 22.50px; padding-bottom: 22.50px; left: 1482px; top: 829px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">CLEAR ALL</div>
        </div>
      </div>
    </div>

    <div style="width: 203px; padding-top: 22.50px; padding-bottom: 22.50px; left: 1482px; top: 991px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">NEXT</div>
        </div>
      </div>
    </div>

    <div style="width: 203px; height: 70px; left: 1482px; top: 748px; position: absolute">
      <div style="width: 203px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
            <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
          </div>
        </div>
      </div>

      <div style="width: 203px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
            <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">BACKSPACE</div>
          </div>
        </div>
      </div>
    </div>

    <div style="width: 268px; height: 70px; left: 1184px; top: 748px; position: absolute">
      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">7</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">8</div>
        </div>
      </div>

      <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
        <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
          <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">9</div>
        </div>
      </div>
    </div>
    
    <div style="width: 1000px; height: 91px; left: 460px; top: 21px; position: absolute; background: #E3E3E3; border-radius: 20px"></div>
    <div style="width: 480px; height: 62px; left: 720px; top: 31px; position: absolute; text-align: center; color: #070707; font-size: 48px; font-family: Lato; font-weight: 600; word-wrap: break-word">Registration</div>
    <div style="width: 1191px; height: 33px; left: 364px; top: 150px; position: absolute; text-align: center; color: #070707; font-size: 32px; font-family: Lato; font-weight: 400; word-wrap: break-word">Please complete the additional information below.</div>
    <div style="width: 186px; height: 36px; left: 431px; top: 246px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Name</div>
    <div style="width: 186px; height: 36px; left: 431px; top: 317px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Date of Birth</div>
    <div style="width: 186px; height: 36px; left: 431px; top: 388px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Gender</div>
    <div style="width: 186px; height: 36px; left: 431px; top: 459px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Mobile</div>
    <div style="width: 744px; height: 36px; left: 658px; top: 540px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">I certify that I have read and accept these Terms of Use</div>
    <div style="width: 244px; height: 36px; left: 907px; top: 459px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Email</div>
    <div style="width: 122px; height: 36px; left: 692px; top: 388px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Male</div>
    <div style="width: 122px; height: 36px; left: 875px; top: 388px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Female</div>
    <div style="width: 40px; height: 36px; left: 1267px; top: 459px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">@</div>
    <div style="width: 300px; height: 60px; left: 810px; top: 615px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>


    <form action="<?= base_url() . 'home/createNewUser' ?>" method="post" id="registration_form">
      <input class="input-field" style="width: 250px; height: 56px; left: 633px; top: 239px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="firstName" id="firstName" placeholder="First Name" required>
      <input class="input-field" style="width: 230px; height: 56px; left: 898px; top: 239px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="middleName" placeholder="Middle Name" required>
      <input class="input-field" style="width: 230px; height: 56px; left: 1143px; top: 239px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="lastName" placeholder="Last Name" required>

      <select class="input-field" style="width: 100px; height: 56px; left: 1388px; top: 239px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="suffix">
        <option value="">Suffix</option>
        <?php
        $suffix = ['Jr', 'Sr'];

        foreach ($suffix as $suffix_row) { ?>
          <option value="<?= $suffix_row ?>"><?= $suffix_row ?></option>;
        <?php } ?>
      </select>

      <select class="input-field" style="width: 250px; height: 56px; left: 633px; top: 310px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="month" id="month">
        <option value="">Month</option>
        <?php
        $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        foreach ($monthNames as $monthName_row) { ?>
          <option value="<?= $monthName_row ?>"><?= $monthName_row ?></option>;
        <?php } ?>
      </select>

      <select class="input-field" style="width: 230px; height: 56px; left: 898px; top: 310px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="day" id="day">
        <option value="">Day</option>
        <?php
        $days = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];

        foreach ($days as $day_row) { ?>
          <option value="<?= $day_row ?>"><?= $day_row ?></option>;
        <?php } ?>
      </select>

      <select class="input-field" style="width: 230px; height: 56px; left: 1143px; top: 310px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="year" id="year">
        <option value="">Year</option>
        <?php
        $currentYear = date('Y');
        $startYear = 1951;
        $endYear = $currentYear;

        for ($year = $startYear; $year <= $endYear; $year++) {
          echo '<option value="' . $year . '">' . $year . '</option>';
        }
        ?>
      </select>
      <input class="" style="width: 100px; height: 56px; left: 1388px; top: 310px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" value="Age" disabled>

      <input type="radio" style="width: 40px; height: 40px; left: 633px; top: 387px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="gender" placeholder="Male" required>
      <input type="radio" style="width: 40px; height: 40px; left: 816px; top: 387px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="gender" placeholder="Female" required>

      <input class="input-field" type="text" style="width: 250px; height: 56px; left: 633px; top: 452px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="contactNumber" placeholder="Number">
      <input class="input-field" type="text" style="width: 230px; height: 56px; left: 1028px; top: 452px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="email" placeholder="Email">
      <input class="input-field" style="width: 182px; height: 56px; left: 1306px; top: 452px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="email_ext" placeholder="Gmail.com">
      <div class="cursor-line"></div>
      <input type="checkbox" style="width: 40px; height: 40px; left: 597px; top: 541px; position: absolute; background: white; border-radius: 10px !important; border: 0.50px black solid" id="termsCheckbox">
      <button type="submit" style="width: 200px; height: 37px; left: 860px; top: 623px; position: absolute; border:none;background: none;text-align: center; color: white; font-size: 30px; font-family: Lato; font-weight: 700; word-wrap: break-word">Submit</button>

    </form>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const monthSelect           = document.getElementById('month');
      const daySelect             = document.getElementById('day');
      const yearSelect            = document.getElementById('year');

      function getMonthNumber(monthName) {
        const dateObj             = new Date(`2000 ${monthName} 01`);
        return dateObj.getMonth() + 1;
      }

      function computeAge() {
        const selectedMonthName   = monthSelect.value;
        const selectedDay         = parseInt(daySelect.value);
        const selectedYear        = parseInt(yearSelect.value);

        if (!isNaN(selectedDay) && !isNaN(selectedYear)) {
          const selectedMonth     = getMonthNumber(selectedMonthName);

          const today             = new Date();
          const birthDate         = new Date(selectedYear, selectedMonth - 1, selectedDay);
          const ageInMilliseconds = today - birthDate;
          const ageInYears        = Math.floor(ageInMilliseconds / (1000 * 60 * 60 * 24 * 365.25));

          const ageInput          = document.querySelector('input[value="Age"]');
          ageInput.value          = `${ageInYears} yrs old`;
        }
      }

      monthSelect.addEventListener('change', computeAge);
      daySelect.addEventListener('change', computeAge);
      yearSelect.addEventListener('change', computeAge);

      computeAge();

      const registration_form     = document.getElementById('registration_form');
      const termsCheckbox         = document.getElementById('termsCheckbox');

      registration_form.addEventListener('submit', function(event) {

        if (!termsCheckbox.checked) {
          event.preventDefault();
          alert('Please accept the Terms of Use before submitting the form.');
        }
      });

      const inputFields           = document.querySelectorAll('.input-field');
      const keys                  = document.querySelectorAll('.key');
      let activeInputField        = null;
      const cursorLine            = document.querySelector('.cursor-line');

      var canvas                  = document.createElement("canvas");
      var context                 = canvas.getContext("2d");
      var width                   = 0;
      keys.forEach(key => {
        key.addEventListener('click', () => {
          if (activeInputField) {

            if (key.textContent === 'BACKSPACE') {
              const currentPosition             = activeInputField.selectionStart;
              if (currentPosition > 0) {
                const newValue                  = activeInputField.value.slice(0, currentPosition - 1) + activeInputField.value.slice(currentPosition);
                activeInputField.value          = newValue;
                activeInputField.selectionStart = currentPosition - 1;
                activeInputField.selectionEnd   = currentPosition - 1;
              }

            } else if (key.textContent === 'CLEAR ALL') {
              activeInputField.value = '';

            } else if (key.textContent === 'NEXT') {
              const currentIndex = Array.from(inputFields).indexOf(activeInputField);
              const nextIndex = (currentIndex + 1) % inputFields.length;
              inputFields[nextIndex].focus();

            } else if (key.textContent === 'SPACEBAR') {
              activeInputField.value += ' ';

            } else {
              const currentPosition             = activeInputField.selectionStart;
              const newValue                    = activeInputField.value.slice(0, currentPosition) + key.textContent + activeInputField.value.slice(currentPosition);
              activeInputField.value            = newValue;
              activeInputField.selectionStart   = currentPosition + 1;
              activeInputField.selectionEnd     = currentPosition + 1;
              width += (context.measureText(key.textContent, "Lato").width);
              console.log(newValue);
            }

          }
        });
      });

      inputFields.forEach(inputField => {
        inputField.addEventListener('focus', () => {
          activeInputField = inputField;
          var width = context.measureText(activeInputField, "Lato").width;
        });
      });

      document.addEventListener('click', event => {
        let clickedInsideInput = false;
        inputFields.forEach(inputField => {
          if (event.target === inputField || inputField.contains(event.target)) {
            clickedInsideInput = true;
          }
        });

        if (!clickedInsideInput && !Array.from(keys).includes(event.target)) {
          activeInputField = null;
          cursorLine.style.display = 'none'; 
        }
      });

      // function moveCursorLine(width) {
      //   if (activeInputField) {

      //     const rect = activeInputField.getBoundingClientRect();
      //     cursorLine.style.display = 'block';
      // console.log(width);
      //     // Calculate the relative distance from the left edge of the viewport
      //     const horizontalDistance = rect.left + width ;
      //     cursorLine.style.left = horizontalDistance + 'px';

      //     // Calculate the relative distance from the top edge of the viewport
      //     const verticalDistance = rect.top + window.scrollY + 15; // Adjust the vertical position as needed
      //     cursorLine.style.top = verticalDistance + 'px';
      //   }
      // }

    });
  </script>
</body>


</html>