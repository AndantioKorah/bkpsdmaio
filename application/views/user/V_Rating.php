<style>
    .star-rating {
        /* display: flex;
        flex-direction: row-reverse; 
        justify-content: flex-end; */
    }

    .star_rating:hover{
        cursor:pointer;
    }

    .star-rating-off{
        color: darkgrey;
        transition: .2s;
    }

    .star-rating-on{
        color: #ffcc008b !important;
        transition: .2s;
    }

    .star-rating-on-click{
        color: #ffcc00 !important;
        transition: .2s;
    }

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
            <input type="radio" id="radio_star_<?=$data['name']?>_<?=$i?>" name="<?=$data['name']?>" value="<?=$i?>" />
            <label for="star_<?=$i?>" title="<?=$i?> stars" id="star_<?=$data['name']?>_<?=$i?>" data-rating="<?=$i?>"
                class="star_rating_<?=$data['name']?>"><i class="fa fa-star fa-2x"></i></label>
        <?php } ?>
    </div>
</div>
<script>
    $('.star_rating_<?=$data['name']?>').hover(
        function() {
            hoverRating($(this).data('rating'), '<?=$data['name']?>')
        },
        function() {
            hoverRating(0, '<?=$data['name']?>')
        }
    );

    $('.star_rating_<?=$data['name']?>').on('click', function(){
        console.log($(this).data('rating'));
        rate = $(this).data('rating')
        for(i = 1; i <= parseInt('<?=$data['skala']?>'); i++){
            if(i <= rate){
                $('#star_'+'<?=$data['name']?>'+'_'+i).addClass('star-rating-on-click')
                $('#radio_star_'+'<?=$data['name']?>'+'_'+i).prop('checked', true)
            } else {
                $('#star_'+'<?=$data['name']?>'+'_'+i).removeClass('star-rating-on-click')
                $('#radio_star_'+'<?=$data['name']?>'+'_'+i).prop('checked', false)
            }
        }
    })

    function hoverRating(rate, name){
        if(rate == 0){
            $('.star_rating_'+name).removeClass('star-rating-on')
            $('.star_rating_'+name).addClass('star-rating-off')
        } else {
            for(i = 1; i <= parseInt('<?=$data['skala']?>'); i++){
                if(i <= rate){
                    $('#star_'+name+'_'+i).removeClass('star-rating-off')
                    if(!$('#star_'+name+'_'+i).hasClass('star-rating-on-click')){
                        $('#star_'+name+'_'+i).addClass('star-rating-on')
                    }
                } else {
                    $('#star_'+name+'_'+i).removeClass('star-rating-on')
                    if(!$('#star_'+name+'_'+i).hasClass('star-rating-on-click')){
                        $('#star_'+name+'_'+i).addClass('star-rating-off')
                    }
                }
            }
        }
    }
</script>