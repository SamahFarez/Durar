var exam_id=examId

function openEditForm(studentId) {
   // Find the row corresponding to the clicked edit button
   var row = $('tr[data-student-id="' + studentId + '"]');

   // Toggle the visibility of the editing elements
   row.find('.remark').toggle();
   row.find('.edit-remark').toggle();
   row.find('.mark').toggle();
   row.find('.edit-mark').toggle();
}

$('.session-3-text').click(function (e) {
   e.preventDefault(); // Prevent the default behavior of the anchor element

   // Iterate over each row in the table
   $('tbody tr').each(function () {
      var row = $(this);

      // Check if the row is in edit mode
      if (row.find('.edit-remark').is(':visible')) {
         // Get the updated values from the input fields
         var remark = row.find('.edit-remark').val();
         var mark = row.find('.edit-mark').val();
         var studentId = row.data('student-id');

         // Update the table cell values with the edited values
         row.find('.remark').text(remark);
         row.find('.mark').text(mark);

         // Make an AJAX request to save the updated values to the database
         $.ajax({
            url: '../../includings/editExam.php',
            method: 'POST',
            data: {
               remark: remark,
               mark: mark,
               student_id: studentId,
               exam_id: examId,
               halakah_id: halakahId,
               halakah_name: halakahName
            },
            success: function (response) {
               // Handle the response from the PHP script
               console.log(response);
               // Redirect to examList.php with the halakah_id parameter
               window.location.href = 'examList.php?halakah_id=' + halakahId + '&halakah_name=' + encodeURIComponent(halakahName);
            },
            error: function (xhr, status, error) {
               // Handle the error, if any
               console.error(error);
            }

         });
      }
   });
});
