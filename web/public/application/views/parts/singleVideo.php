<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12 center-block'>
		<video id="videojs-overlay-player" class="video-js vjs-default-skin" controls width="auto" height="auto">
			<source src="<?= $video->src; ?>" type='<?= $video->type ?>'>
		</video>
	</div>
</div>

<div id='tabs'>
    <ul>
        <li><a href="#add-annotation-gui">Add Annotation</a></li>
        <li><a href="#delete-annotation-gui" onclick='loadAnnotations()'>Edit Annotations</a></li>
    </ul>

    <div id='add-annotation-gui' class='row'>
        <div class='col-sm-12 col-md-12 col-lg-12'>
            <h2>Annotate</h2>
            <div class="well">
                <div class='row'>
                    <div class='col-md-5 col-sm-5'>
                        <h3>Annotation Text</h3>
                        <input id="text" type="textfield"></input>
                    </div>
                    <div class='col-md-5 col-sm-5 pull-right'>
                        <h3>Annotation Time</h3>
                        Use the yellow sliders on the video to adjust when the annotation will be applied.
                    </div>
                </div>

                <h3>Position</h3>
                <label>Top Left</label>
                <input id="position-tl" name="position" type="radio" value="top-left" checked>

                <label>| Top</label>
                <input id="position-t" name="position" type="radio" value="top">

                <label>| Top Right</label>
                <input id="position-tr" name="position" type="radio" value="top-right">

                <label>| Right</label>
                <input id="position-r" name="position" type="radio" value="right">

                <label>| Bottom Right</label>
                <input id="position-br" name="position" type="radio" value="bottom-right">

                <label>| Bottom</label>
                <input id="position-b" name="position" type="radio" value="bottom">

                <label>| Bottom Left</label>
                <input id="position-bl" name="position" type="radio" value="bottom-left">

                <label>| Left</label>
                <input id="position-l" name="position" type="radio" value="left">
                <br>
                <br>
                <button id="save" class='btn btn-primary' onClick="annotate()">Save Annotation</button>
            </div>
        </div>
    </div>

    <div id='delete-annotation-gui' class='row'>
        <div id='annotation-spinner' class='col-sm-12 col-md-12 col-lg-12 text-center'>
            <i class='fa fa-spinner fa-spin'></i>
        </div>
        <div id='annotation-table'>
            <div class='row'>
                <div class='col-sm-1 col-md-1 col-lg-1'>
                    <h4>Delete?</h4>
                </div>
                <div class='col-sm-1 col-md-1 col-lg-1'>
                    <h4>Start</h4>
                </div>
                <div class='col-sm-1 col-md-1 col-lg-1'>
                    <h4>End</h4>
                </div>
                <div class='col-sm-6 col-md-6 col-lg-6'>
                    <h4>Text</h4>
                </div>
                <div class='col-sm-1 col-md-1 col-lg-1'>
                    <h4>Position</h4>
                </div>
                <div class='col-sm-1 col-md-1 col-lg-1'>
                    <h4>User</h4>
                </div>
            </div>
        </div>
    </div>
</div>


<br>
<div class="row">
    <div class='col-sm-12 col-md-12 col-lg-12'>
        <div class="container-fluid well well-sm">
            <div class='row'>
                <div class='col-md-12 col-sm-12 col-lg-12'>
                    <h3><?= $video->title ?></h3>
                </div>
            </div>
            <br>
            <div class='row'>
                <div class='col-md-2'>
                    <img class='profile-pic-icon' src="<?= $user->profile_picture ?>">
                </div>
                <div class='col-md-6'>
                    <a href="/users/profile/<?= $user->username; ?>"><h5><?= $user->username; ?></h5></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class='col-sm-12 col-md-12 col-lg-12'>
        <div class="well">
            <div>

            </div>
            <div>
                <?= $video->description; ?>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function(){
    /* Hide the edit spinner for now */
    $('#annotation-spinner').hide();

    /* Instantiate the tabs for the annotation GUI */
    $(function() {
        $( "#tabs" ).tabs();
    });
});

/* Update the position variable every time a radio option changes */
var position = 'top-left';
$("input:radio[name=position]").click(function() {
    position = $(this).val();
});

/* Event delegation for the deletion of annotations */
$(document).on('click', '.del-annotation', function(){

    var rid = $(this).data('rid');
    var self = this;

    $.post( "/api/deleteAnnotation", {  
                                    id: rid
                                 },
        function() {
          $(self).parent().parent().remove();
          alert('Your annotation has been deleted from the server, but you will need to refresh to remove it locally.');
          console.log("Successfully deleted annotation.");
        })
          .fail(function() {
            alert( "error" );
        });
});

/* Load the overlays from the database */
var overlays = <?= $overlays ?>;

/* Set up the videoJS player with the rangeslider */
(function(window, videojs) {
  var player = window.player = videojs('videojs-overlay-player');
  player.overlay({
    overlays: overlays
  });

  options = {	hidden:false,
  				controlTime:true };
  player.rangeslider(options)
}(window, window.videojs));

/* Save annotations, add to list, and clear the forms when the button is clicked */
annotate = function(){
    var mPlayer = videojs("videojs-overlay-player");
    times = mPlayer.getValueSlider();
    timeString = "[" + times.start + ', ' + times.end + ']';
    
    annotation = $('#text').val();
    overlays.push({content:annotation, start:times.start, end:times.end, align:position});
    
    mPlayer.overlay({
        overlays: overlays
    });

    var jqxhr = $.post( "/api/annotateText", {  
                                                text:annotation, 
                                                start:times.start, 
                                                end:times.end, 
                                                video_id:"<?= $video->id ?>", 
                                                user_id:"<?= $this->session->userdata('id') ?>",
                                                position:position
                                            },
                    function() {
                      console.log("Successfully saved annotation.");
                    })
                      .fail(function() {
                        alert( "error" );
                    });

    $('#text').val('');
    $('#position-tl').prop('checked', true);
}

/* Generates an annotation element */
annotationRow = function(id, start, end, text, position, username){
    var elementString = "<div class='row'>" +
                            "<div class='col-sm-1 col-md-1 col-lg-1'>" +
                                "<button class='btn btn-danger del-annotation' data-rid='" + id + "'>Delete</button>" +
                            "</div>" +
                            "<div class='col-sm-1 col-md-1 col-lg-1'>" +
                                + start + "s" +
                            "</div>" +
                            "<div class='col-sm-1 col-md-1 col-lg-1'>" +
                                end + "s" +
                            "</div>" +
                            "<div class='col-sm-6 col-md-6 col-lg-6'>" +
                                text +
                            "</div>" +
                            "<div class='col-sm-1 col-md-1 col-lg-1'>" +
                                position +
                            "</div>" +
                            "<div class='col-sm-1 col-md-1 col-lg-1'>" +
                                username +
                            "</div>" +
                        "</div>";
    var element = $.parseHTML( elementString );
    return element;
}

loadAnnotations = function(){
    //hide the content
    $('#annotation-table').hide();
    //Show the spinner
    $('#annotation-spinner').show();
    //Get the data
    $.post( "/api/getAnnotations",  {  
                                        video_id: <?= $video->id ?>
                                    },
        function(data) {

            setTimeout(function(){
                //present the data
                var json = JSON.parse(data);
                if(json.length == 0){
                    $('#annotation-table').html($.parseHTML("<div class='row'><div class='col-sm-12 col-md-12 col-lg-12 text-danger'>It looks like there are no annotations yet!</div></div>"));
                }

                for(var i = 0; i < json.length; i++){
                    var a = json[i];
                    $('#annotation-table').append(annotationRow(a.id, a.annotation.start_time, a.annotation.end_time, a.text, a.annotation.position, a.annotation.user.username));
                }

                //hide the spinner
                $('#annotation-spinner').hide();
                //show the content
                $('#annotation-table').show();
            }, 1000);
             
        })
          .fail(function() {
            alert( "error" );
        });

    
}
</script>

