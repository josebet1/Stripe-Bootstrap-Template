		var chargeAmount = 0;  //Create a global var to store the corrected non-decimal amount
            //Stripe.setPublishableKey('<? echo $PublishableKey ?>'); 
            function stripeResponseHandler(status, response) {
               if (response.error.param=='amount') {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html("An invalid amount was entered");
								}
                else if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
	                  // insert the stripe non decimal payment amount
										form$.append("<input type='hidden' name='stripe-amount' value='" + chargeAmount + "' />");
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
										// and submit
										form$.get(0).submit();
                }
            }

            $(document).ready(function() {
                if($(".parent").find(".nojs").size()){
									$(".parent").find(".nojs").style.display="none"; // Hide the nojs detected box if still visible
								}
								document.getElementById('client-number').select(); //set input to the first field

								$('.submit-button').removeAttr("disabled"); //Enable the submit button (disabled for no js)
								$('.submit-button').html("Submit Payment"); //Set the submit button text
								$('#submit-label').html("Ready to pay"); //Set the submit button text
								
								
								$("#payment-form").submit(function(event) {
 									 	//Clear any prior errors while authorizing
										$(".payment-errors").html('');
										
										//Verify any fields required to be filled (start at the top and work down)
										if ( $('#client-number').val()==null || $('#client-number').val()=="" )	{
                			$(".payment-errors").html("A Client # or Case Name is required");
   										document.getElementById('client-number').select();
 											return false;
  									}
										if ( $('#card-name').val()==null || $('#card-name').val()=="" )	{
                			$(".payment-errors").html("The Full Name from the Card is required");
   										document.getElementById('card-name').select();
											return false;
  									}
                    
										//Verify email addresses match
										if ( $('#card-email').val() != $('#card-email2').val() ) {
                			$(".payment-errors").html("The email addresses do not match");
   										document.getElementById('card-email').select();
											return false;
										}
										
										//Verify email address layout X@X.X
										if ( !validateEmail( $('#card-email').val() ) ) {
   										document.getElementById('card-email').select();
											return false;
										}

										// disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
										chargeAmount = (parseFloat($('#card-amount').val())*100).toFixed(); 
										// createToken returns immediately - the supplied callback submits the form if there are no errors
										Stripe.createToken({
                        name: $('#card-name').val(),
                        address_line1: $('#card-address-1').val(),
                        address_line2: $('#card-address-2').val(),
                        address_zip: $('#card-address-zip').val(),
                        address_state: $('#card-address-state').val(),
                        number: $('#card-number').val(),
                        cvc: $('#card-cvc').val(),
                        exp_month: $('#card-expiry-month').val(),
                        exp_year: $('#card-expiry-year').val()
                    }, chargeAmount, stripeResponseHandler);
                    return false; // submit from callback
                });
            });


						function validateEmail(email) {
							if (email==null || email=="")	{
                $(".payment-errors").html("An email address is required");
  							return false;
  						}

							emailRegex = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.(([a-z]{2}|AERO|ARPA|ASIA|BIZ|CAT|COM|COOP|EDU|GOV|INFO|INT|JOBS|MIL|MOBI|MUSEUM|NAME|NET|ORG|PRO|TEL|TRAVEL|XN--0ZWM56D|XN--11B5BS3A9AJ6G|XN--3E0B707E|XN--45BRJ9C|XN--80AKHBYKNJ4F|XN--90A3AC|XN--9T4B11YI5A|XN--CLCHC0EA0B2G2A9GCD|XN--DEBA0AD|XN--FIQS8S|XN--FIQZ9S|XN--FPCRJ9C3D|XN--FZC2C9E2C|XN--G6W251D|XN--GECRJ9C|XN--H2BRJ9C|XN--HGBK6AJ7F53BBA|XN--HLCJ6AYA9ESC7A|XN--J6W193G|XN--JXALPDLP|XN--KGBECHTV|XN--KPRW13D|XN--KPRY57D|XN--LGBBAT1AD8J|XN--MGBAAM7A8H|XN--MGBAYH7GPA|XN--MGBBH1A71E|XN--MGBC0A9AZCG|XN--MGBERP4A5D4AR|XN--O3CW4H|XN--OGBPF8FL|XN--P1AI|XN--PGBS0DH|XN--S9BRJ9C|XN--WGBH1C|XN--WGBL6A|XN--XKC2AL3HYE2A|XN--XKC2DL3A5EE0H|XN--YFRO4I67O|XN--YGBI2AMMX|XN--ZCKZAH|XXX)(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)|(^$)/i;

							if (!emailRegex.test(email)) {
                $(".payment-errors").html("The email address ("+email+") is invalid");
								return false;
							}
						return true;
						}
