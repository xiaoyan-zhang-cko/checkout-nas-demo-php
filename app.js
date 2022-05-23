var payButton = document.getElementById("pay-button");
var form = document.getElementById("payment-form");

Frames.init({
  publicKey: "pk_sbox_XXXXXXXXXXXXXXXXXXXXX",
  frameSelector: ".card-frame",
  localization: "FR-FR",
  debug: false
});

Frames.addEventHandler(
  Frames.Events.CARD_VALIDATION_CHANGED,
  onCardValidationChanged
);

function onCardValidationChanged(event) {
  console.log("CARD_VALIDATION_CHANGED: %o", event);

  var errorMessage = document.querySelector(".error-message");
  payButton.disabled = !Frames.isCardValid();
}

Frames.addEventHandler(
  Frames.Events.FRAME_VALIDATION_CHANGED,
  onValidationChanged
);

function onValidationChanged(event) {
  console.log("FRAME_VALIDATION_CHANGED: %o", event);

  var errorMessage = document.querySelector(".error-message");
  errorMessage.textContent = getErrorMessage(event);
}

var errors = {};
errors["card-number"] = "Please enter a valid card number";
errors["expiry-date"] = "Please enter a valid expiry date";
errors["cvv"] = "Please enter a valid cvv code";

function getErrorMessage(event) {
  if (event.isValid || event.isEmpty) {
    return "";
  }

  return errors[event.element];
}

Frames.addEventHandler(
  Frames.Events.CARD_TOKENIZATION_FAILED,
  onCardTokenizationFailed
);

function onCardTokenizationFailed(error) {
  console.log("CARD_TOKENIZATION_FAILED: %o", error);
  Frames.enableSubmitForm();
}

Frames.addEventHandler(Frames.Events.CARD_TOKENIZED, onCardTokenized);

function onCardTokenized(event) {
  var el = document.querySelector(".success-payment-message");
  el.innerHTML =
    "Card tokenization completed<br>" +
    'Your card token is: <span class="token">' + event.token
    "</span>";
  console.log("CARD_TOKENIZED: %o", event.token);

  postPayment(event.token);
}

form.addEventListener("submit", function (event) {
  event.preventDefault();
  Frames.submitCard();
});


function postPayment(framesToken) {
  console.log(framesToken);
  $.post("server/payment.php",
      {
        cko_card_token: framesToken,
      }, function (data) {
        $('.paymentwrapper').html(
            `<pre>` + data + `</pre>`)
      });
}
