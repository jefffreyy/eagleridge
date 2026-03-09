<?php $this->load->view('templates/css_link'); ?>


<html>
<style>
    /* Add some basic styling to the keyboard layout */
    .keyboard {
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        gap: 5px;
        padding: 10px;
    }

    .key {

        height: 50px;
        border: 1px solid #ccc;
        background-color: #fff;
        text-align: center;
        line-height: 40px;
        cursor: pointer;
    }

    .keyboard_number {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 5px;
        padding: 10px;
    }

    /* Flexbox styling to arrange form and keyboard vertically */
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Center items horizontally */
        margin: 0;
    }
</style>

<!-- <body style="display: flex; justify-content: center; align-items: center;margin: 0;">
    <div class="container">
        <div>
            <h2>Login</h2>
        </div>
        <br>
        <br>
        <form action="" method="post">
            <label for="user_id">User ID</label>
            <input type="text" name="user_id" id="user_id">
            <br>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name">
            <br><br>
            <a href="<?= base_url() ?>home/selectoption">
                <div lass="btn btn-success">
                    Submit
                </div>
            </a>

        </form>
        <br>
        <div style="user-select: none;user-select: none;user-select: none;width:100vw; height:30vh; background-color: #B8CBE9;">
            <div class="row">
                <div class="col-md-3"></div>

                <div class="col-md-4">
                    <div class="keyboard">
                        <div class="key">Q</div>
                        <div class="key">W</div>
                        <div class="key">E</div>
                        <div class="key">R</div>
                        <div class="key">T</div>
                        <div class="key">Y</div>
                        <div class="key">U</div>
                        <div class="key">I</div>
                        <div class="key">O</div>
                        <div class="key">P</div>
                        <div class="key">A</div>
                        <div class="key">S</div>
                        <div class="key">D</div>
                        <div class="key">F</div>
                        <div class="key">G</div>
                        <div class="key">H</div>
                        <div class="key">J</div>
                        <div class="key">K</div>
                        <div class="key">L</div>
                        <div class="key">Z</div>
                        <div class="key">X</div>
                        <div class="key">C</div>
                        <div class="key">V</div>
                        <div class="key">B</div>
                        <div class="key">N</div>
                        <div class="key">M</div>
                        <div class="key">delete</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="keyboard_number">
                        <div class="key">7</div>
                        <div class="key">8</div>
                        <div class="key">9</div>
                        <div class="key">4</div>
                        <div class="key">5</div>
                        <div class="key">6</div>
                        <div class="key">1</div>
                        <div class="key">2</div>
                        <div class="key">3</div>
                        <div class="key">0</div>
                        <div class="key">.</div>


                    </div>


                </div>
                <div class="col-md-3"></div>


            </div>


        </div>

    </div>


</body> -->
<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">

<div style="user-select: none;user-select: none;user-select: none;width: 1920px; height: 1080px; position: relative">
  <!-- <div style="user-select: none;user-select: none;user-select: none;width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: #E6EAEE"></div> -->
  <div style="user-select: none;user-select: none;user-select: none;width: 1920px; height: 350px; left: 0px; top: 730px; position: absolute; background: #B8CBE9"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 1920px; height: 350px; left: 0px; top: 730px; position: absolute; background: #B8CBE9"></div>
  <!-- <img style="width: 141px; height: 141px; left: 14px; top: 10px; position: absolute" src="https://via.placeholder.com/141x141" /> -->
  <div style="user-select: none;user-select: none;user-select: none;width: 640px; height: 70px; left: 375px; top: 910px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Z</div>
        </div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">X</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">C</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">V</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">B</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">N</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">M</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 640px; height: 70px; left: 375px; top: 991px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 640px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
        </div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 640px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
        </div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 826px; height: 70px; left: 282px; top: 829px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">A</div>
        </div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">S</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">D</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">F</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">G</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">H</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">J</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 651px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">K</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 744px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">L</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 919px; height: 70px; left: 235px; top: 748px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Q</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">W</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">E</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">R</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">T</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Y</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">U</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 651px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">I</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 744px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">O</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 837px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">P</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 268px; height: 70px; left: 1184px; top: 829px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">4</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">5</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">6</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 268px; height: 70px; left: 1184px; top: 910px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">1</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">2</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">3</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 175px; height: 70px; left: 1184px; top: 991px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">.</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">0</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 203px; padding-top: 22.50px; padding-bottom: 22.50px; left: 1482px; top: 829px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
    <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">CLEAR ALL</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 203px; padding-top: 22.50px; padding-bottom: 22.50px; left: 1482px; top: 991px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
    <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">NEXT</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 203px; height: 70px; left: 1482px; top: 748px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 203px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
        </div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 203px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">BACKSPACE</div>
        </div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 268px; height: 70px; left: 1184px; top: 748px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">7</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">8</div>
      </div>
    </div>
    <div style="user-select: none;user-select: none;user-select: none;width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #DDE0E5; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="user-select: none;user-select: none;user-select: none;flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="user-select: none;user-select: none;user-select: none;align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">9</div>
      </div>
    </div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 1000px; height: 91px; left: 460px; top: 26px; position: absolute; background: #E3E3E3; border-radius: 20px"></div>
        <div style="user-select: none;user-select: none;user-select: none;width: 480px; height: 62px; left: 720px; top: 36px; position: absolute; text-align: center; color: #070707; font-size: 48px; font-family: Lato; font-weight: 600; word-wrap: break-word">Login</div>
        <!-- <div style="user-select: none;user-select: none;user-select: none;width: 1191px; height: 33px; left: 364px; top: 150px; position: absolute; text-align: center; color: #070707; font-size: 32px; font-family: Lato; font-weight: 400; word-wrap: break-word">Please select appropriate option</div> -->
    </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 186px; height: 36px; left: 660px; top: 242px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">User ID</div>
  <div style="user-select: none;user-select: none;user-select: none;width: 186px; height: 36px; left: 660px; top: 379px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Last Name</div>
  <!-- <div style="user-select: none;user-select: none;user-select: none;width: 200px; height: 80px; left: 1674px; top: 41px; position: absolute; background: #B8CBE9; border-radius: 20px"></div> -->

  <!-- <a href="<?= base_url() ?>home/userselections">
  <div style="user-select: none;user-select: none;user-select: none;width: 200px; height: 37px; left: 1674px; top: 59px; position: absolute; text-align: center; color: white; font-size: 32px; font-family: Lato; font-weight: 700; word-wrap: break-word">Back</div>
    </a> -->
    
  <div style="user-select: none;user-select: none;user-select: none;width: 300px; height: 60px; left: 810px; top: 525px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <form action="<?= base_url().'home/selectoption'?>" method="post" id="registration_form">
    <button type="submit" style="width: 200px; height: 37px; left: 860px; top: 533px; position: absolute; text-align: center; border:none; background: none; color: white; font-size: 30px; font-family: Lato; font-weight: 700; word-wrap: break-word"name ="login">Login</button>
    <input class="input-field"  style="width: 600px; height: 56px; left: 660px; top: 292px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="user_id">
    <input class="input-field"  style="width: 600px; height: 56px; left: 660px; top: 429px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid" name="last_name">
    
  </form>



</body>
<script>
function BlockMove(event) { 
  event.preventDefault(); 
}


</script>

</html>