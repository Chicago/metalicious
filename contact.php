<?php

include 'include/header.php';

?>
<script>
    $(document).ready(function() {
        $("#First_Name").focus();
    });
</script>

<!-- container started in header.php -->

    <div class="row-fluid">
        <div class="span8">
            <h1>Contact Us</h1>
            
            <div id="contact_message_box" class="alert alert-block" style="display: none;"></div>
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="span2">
                        First Name:
                    </td>
                    <td>
                        <input type="text" name="First_Name" id="First_Name" value="" class="span7" />
                    </td>
                </tr>
                <tr>
                    <td class="span2">
                        Last Name:
                    </td>
                    <td>
                        <input type="text" name="Last_Name" id="Last_Name" value="" class="span7" />
                    </td>
                </tr>
                <tr>
                    <td class="span2">
                        Email:
                    </td>
                    <td>
                        <input type="text" name="Email" id="Email" value="" class="span7" />
                    </td>
                </tr>
                <tr>
                    <td class="span2">
                        Comment / Question:
                    </td>
                    <td>
                        <textarea name="Comment_Question" id="Comment_Question" rows="6" class="span7"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="span2">
                    </td>
                    <td>
                        <a href="javascript:;" class="btn btn-primary"
                               onclick="
                                    $.post(
                                        'ajax/contact_send.php',
                                        {
                                            First_Name: document.getElementById('First_Name').value,
                                            Last_Name: document.getElementById('Last_Name').value,
                                            Email: document.getElementById('Email').value,
                                            Comment_Question: document.getElementById('Comment_Question').value
                                        },
                                        function (response){
                                            if (response == '') {
                                                document.getElementById('First_Name').value = '';
                                                document.getElementById('Last_Name').value = '';
                                                document.getElementById('Email').value = '';
                                                document.getElementById('Comment_Question').value = '';
                                                
                                                document.getElementById('contact_message_box').innerHTML = '<i class=\'icon-ok\'></i> Thank you for your comment / question';
                                                $('#contact_message_box').attr('class', 'alert alert-success');
                                                $('#contact_message_box').slideDown('slow').delay(3000).slideUp('slow');
                                            } else {
                                                document.getElementById('contact_message_box').innerHTML = '<i class=\'icon-warning-sign\'></i> An error occurred while sending your message: ' + response;
                                                $('#contact_message_box').attr('class', 'alert alert-error');
                                                $('#contact_message_box').slideDown('slow').delay(8000).slideUp('slow');
                                            }
                                        }
                                    );"
                               >Send</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="span4">
          <h3></h3>
        </div>
    </div> 

<?php include 'include/footer.php'; ?>
