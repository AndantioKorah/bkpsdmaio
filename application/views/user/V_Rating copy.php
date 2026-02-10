<style>
    .star-rating {
        /* display: flex;
        flex-direction: row-reverse; 
        justify-content: flex-end; */
    }

    /* Hide the actual radio input buttons */
    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        color: #ccc; /* Default color (grey/unfilled) */
        cursor: pointer;
        padding: 0 2px;
        /* Add a smooth transition for hover/checked states */
        transition: color 0.2s ease-in-out; 
    }

    /* Style for when a label is hovered over */
    /* .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffcc00;
    } */

    /* Style for when a radio button is checked */
    /* .star-rating input[type="radio"]:checked ~ label {
        color: #ffcc00;
    } */
</style>
<div class="row">
    <div class="col-lg-12 text-center star-rating">
        <?php for($i = 1; $i <= $data['skala'] ; $i++){ ?>
            <input type="radio" id="star_<?=$i?>" name="<?=$data['name']?>" value="<?=$i?>" />
            <label for="star_<?=$i?>" title="<?=$i?> stars"><i class="fa fa-star fa-2x"></i></label>
        <?php } ?>
    </div>
</div>
<script>
    // $('.star_rating_<?=$data['name']?>').hover(
    //     function() {
    //         hoverRating($(this).data('rating'))
    //     },
    //     function() {
    //         hoverRating(0)
    //     }
    // );

    // $('.star_rating_<?=$data['name']?>').on('click', function(){
    //     rate = $(this).data('rating')
    //     for(i = 1; i <= parseInt('<?=$data['skala']?>'); i++){
    //         if(i <= rate){
    //             $('#star_'+'<?=$data['name']?>'+'_'+i).addClass('star-rating-on-click')
    //         } else {
    //             $('#star_'+'<?=$data['name']?>'+'_'+i).removeClass('star-rating-on-click')
    //         }
    //     }
    // })

    // function hoverRating(rate){
    //     if(rate == 0){
    //         $('.star_rating_<?=$data['name']?>').removeClass('star-rating-on')
    //         $('.star_rating_<?=$data['name']?>').addClass('star-rating-off')
    //     } else {
    //         for(i = 1; i <= parseInt('<?=$data['skala']?>'); i++){
    //             if(i <= rate){
    //                 $('#star_'+'<?=$data['name']?>'+'_'+i).removeClass('star-rating-off')
    //                 if(!$('#star_'+'<?=$data['name']?>'+'_'+i).hasClass('star-rating-on-click')){
    //                     $('#star_'+'<?=$data['name']?>'+'_'+i).addClass('star-rating-on')
    //                 }
    //             } else {
    //                 $('#star_'+'<?=$data['name']?>'+'_'+i).removeClass('star-rating-on')
    //                 if(!$('#star_'+'<?=$data['name']?>'+'_'+i).hasClass('star-rating-on-click')){
    //                     $('#star_'+'<?=$data['name']?>'+'_'+i).addClass('star-rating-off')
    //                 }
    //             }
    //         }
    //     }
    // }
</script>