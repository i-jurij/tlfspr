<form method="post" action="" name="contact_form" class="form padtb" id="contact_form">

  <div class="margin_bottom_1rem">
    <h2>Enter data of contact</h2>
  </div>
  <div class="margin_bottom_1rem">
    <label class="">Name, 1-3 words, 50 symbols max<br />
      <input type="text" name="name" id="name" minlength="3" maxlength="50" placeholder="First Second Third"
        title="Формат: +7 999 999 99 99" pattern="^[a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ]?+[a-zA-Zа-яА-ЯёЁ]?+{3,50}$"
        value="<?php echo (isset($data['name'])) ? mb_convert_case(mbStrReplace('_', ' ', $data['name']), MB_CASE_TITLE) : null; ?>"
        autocomplete="off" required />
    </label>
  </div>

  <div class="margin_bottom_1rem">
    <label class="">Phone number, 12 digits max<br />
      <input type="tel" name="number" id="number" class="number" title="Формат: +7 999 999 99 99"
        placeholder="+7 ___ ___ __ __"
        pattern="(\+?7|8)?\s?[\(]{0,1}?\d{3}[\)]{0,1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?\d{1}\s?[\-]{0,1}?"
        value="<?php echo (isset($data['number'])) ? phone_number_view($data['number']) : null; ?>"
        autocomplete="off" required>
      </input>
    </label>
  </div>

  <div class="capcha">
    <div class="imgs div_center" style="width:21rem;"></div>
  </div>

  <button type="submit" class="buttons sub"><?php echo (isset($data['submit_button_text'])) ? $data['submit_button_text'] : 'Submit'; ?></button>
</form>