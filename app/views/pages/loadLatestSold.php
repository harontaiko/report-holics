<p id="sales-made-p">Sales made today</p>
<?php  while ($latest = $data['latest']->fetch_assoc()) :   ?>
<p id="<?php echo $latest['sales_id']; ?>" class="total-sales-out-cash"><?php echo $latest['sales_item'];?>
    <button class="close-sale" type="button">&times;</button>
</p>

<?php  endwhile   ?>
<script>
cancelSale = document.querySelectorAll(".close-sale");

for (var i = 0; i < cancelSale.length; i++) {
    cancelSale[i].addEventListener("click", function(event) {
        if (!confirm("Cancel this sale?")) {
            event.preventDefault();
        } else {
            //del from db
            currentId = this.parentNode.id;
            hideParent = this.parentElement.style.display = "none";
            $.ajax({
                url: `<?php echo URLROOT; ?>/pages/DeleteSaleNow`,
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