<p id="sales-made-p">Today's Expenses</p>
<?php  while ($latest = $data['latest']->fetch_assoc()) :   ?>
<p id="<?php echo isset($latest['expense_id']) ? $latest['expense_id']: 'N/A'; ?>" class="total-expense">
    <?php echo isset($latest['expense_item']) ? $latest['expense_item']: 'N/A';?> -
    <?php echo isset($latest['expense_cost']) ? $latest['expense_cost']: 'N/A';?>
    <button class="close-expense" type="button">&times;</button>
</p>

<?php  endwhile   ?>
<script>
cancelExpense = document.querySelectorAll(".close-expense");

for (var i = 0; i < cancelExpense.length; i++) {
    cancelExpense[i].addEventListener("click", function(event) {
        if (!confirm("delete expense?")) {
            event.preventDefault();
        } else {
            //del from db
            currentId = this.parentNode.id;
            hideParent = this.parentElement.style.display = "none";
            $.ajax({
                url: `<?php echo URLROOT; ?>/pages/DeleteExpenseNow`,
                type: "POST",
                data: {
                    id: currentId
                },
                dataType: "json",
                success: function(dataResult) {
                    if (dataResult.statusCode == 200) {
                        //success, del element from DOM
                        hideParent;
                    } else if (dataResult.statusCode == 317) {
                        //for some reason, the id is not present once user accepts condition so, 
                        //fx is true all the time
                        hideParent;
                    }
                },
            });
        }
    });
}
</script>