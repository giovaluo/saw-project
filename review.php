<h1 class="mt-6 title is-1">Lascia la tua recensione <?php echo $_SESSION["firstname"]; ?></h1>
<h4 class="subtitle is-3 has-text-grey">Il tuo parere è importante!</h4>
<div class="container">
    <form action="review_script.php" method="post">
        <div class="rating">
            <input type="number" name="rating" hidden="hidden">
            <div class="star">
                <i class='fa fa-star' style="--i: 0;"></i>
            </div>
            <div class="star">
                <i class='fa fa-star' style="--i: 1;"></i>
            </div>
            <div class="star">
                <i class='fa fa-star' style="--i: 2;"></i>
            </div>
            <div class="star">
                <i class='fa fa-star' style="--i: 3;"></i>
            </div>
            <div class="star">
                <i class='fa fa-star' style="--i: 4;"></i>
            </div>
        </div>
        <div class="column">
            <textarea class="textarea" name="opinion" rows="5" placeholder="Scrivi cosa ne pensi..."></textarea>
        </div>
        <div class="buttons">
            <?php
                echo '<button class="button is-link is-responsive" type="submit" name="review" value = "'.$recordid.'">Invia recensione</button>'
            ?>
        </div>
    </form>
</div>