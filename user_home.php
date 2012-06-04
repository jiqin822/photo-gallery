<?php
require_once 'connect.php';
require_once 'user_home_php.php';
session_start();
require_once 'comment.php';
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:spry="http://ns.adobe.com/spry">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <title>Gallery</title>
        <link href="css/demo_rules.css" rel="stylesheet" type="text/css" />
        <link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            <!--
            /* We want to remove any specified width on the menu bar
             * menu items.
            */

            ul.MenuBarHorizontal li {
                width: auto;
            }

            /* Remove any widths on sub menus. */

            ul.MenuBarHorizontal ul {
                width: auto;
            }

            /* We want the menu items in our sub menus to
             * fill up the entire width of the sub menu, so
             * make sure it is display:block and not floated.
             * Also remove any specified width from the default
             * style sheet and turn on "nowrap".
            */

            ul.MenuBarHorizontal ul li {
                display: block;
                float: none;
                width: auto;
                white-space: nowrap;
                border-bottom: solid 1px #EEE;
            }

            /* Now that our menus auto size horizontally, we need to
             * make sure that we have some space for any sub menu indicators
             * so they don't overlap with the text in the menu item.
            */

            ul.MenuBarHorizontal a.MenuBarItemSubmenu {
                padding: 0.5em 2em 0.5em 0.75em;
            }

            -->
        </style>
        <script type="text/javascript" src="includes/SpryMenuBar.js"></script>
        <script type="text/javascript" src="includes/xpath.js"></script>
        <script type="text/javascript" src="includes/SpryData.js"></script>
        <script type="text/javascript" src="includes/SpryEffects.js"></script>
        <script type="text/javascript" src="feather.js"></script>
        <script src="gallery.js"  type="text/javascript"></script>

        <!-- Instantiate Feather -->
        <script type="text/javascript">
            var featherEditor = new Aviary.Feather({
                apiKey: 'd1b33b8f1',
                apiVersion: 2,
                tools: 'all',
                appendTo: '',
                onSave: function(imageID, newURL) {
                    var img = document.getElementById(imageID);
                    img.src = newURL;
                }
                ,onLoad: function() {
                    document.getElementById('edit-button').style.display = 'block';
                }
            });
        </script>
        <script type="text/javascript"  src="jquery-1.7.2.min.js"></script>
        <script>
            $(document).ready(function () {
                document.getElementById('edit-button').style.display = 'block';
                featherEditor.launch();
            });
        </script>
        <!-- Instantiate Spry -->
        <script type="text/javascript">
            var dsGalleries = new Spry.Data.XMLDataSet("galleries/<? echo $_SESSION['UserID']; ?>.xml", "galleries/gallery");
            var dsGallery = new Spry.Data.XMLDataSet("galleries/{dsGalleries::@base}{dsGalleries::@file}", "gallery");
            var dsPhotos = new Spry.Data.XMLDataSet("galleries/{dsGalleries::@base}{dsGalleries::@file}", "gallery/images/photo");
        </script>

    </head>
    <body id="gallery" >
        <!-- the menu bar -->
        <ul id="MenuBar1" class="MenuBarHorizontal">
            <li>
                <div id="greeting">
                    <? echo $nickName; ?>'s
                </div>
            </li>
            <li><a  href="upload_image.php">Upload Images</a>
            </li>
            <li><a href="create_album.php">Create new Album</a></li>
            <li><a class="MenuBarItemSubmenu" href="#">Edit</a>
                <ul>
                    <li><a class="MenuBarItemSubmenu" href="#" id="edit-button" onclick="return PhotoEdit();">
                            Edit!
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href = "log_out.php">Logout</a></li>
        </ul>
        <script type="text/javascript">
            <!--
            var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", null);
            //-->
        </script>

        <div id="wrap">
            <div id="previews">
                <!-- all galleries -->
                <div id="galleries" spry:region="dsGalleries">
                    <label for="gallerySelect">View:</label>
                    <select spry:repeatchildren="dsGalleries" spry:choose="choose" id="gallerySelect" onchange="dsGalleries.setCurrentRowNumber(this.selectedIndex);">
                        <option spry:when="{ds_RowNumber} == {ds_CurrentRowNumber}" selected="selected">{sitename}</option>
                        <option spry:default="default">{sitename}</option>
                    </select>
                </div>
                <!-- the thumbnails-->
                <div id="thumbnails" draggable="true" spry:region="dsPhotos dsGalleries dsGallery">
                    <div spry:repeat="dsPhotos"
                         onclick="HandleThumbnailClick('{ds_RowID}');"
                         onmouseover="GrowThumbnail(this.getElementsByTagName('img')[0], '{@thumbwidth}', '{@thumbheight}');"
                         onmouseout="ShrinkThumbnail(this.getElementsByTagName('img')[0]);">
                        <img id="tn{ds_RowID}" alt="thumbnail for {@thumbpath}"
                             src="galleries/{dsGalleries::@base}{dsGallery::thumbnail/@base}{@thumbpath}"
                             width="24" height="24" style="left: 0px; right: 0px;" />
                    </div>
                    <p class="ClearAll"></p>
                </div>
            </div>
            <div id="picture">
                <div id="mainImageOutline" style="width: 0px; height: 0px;">
                    <img id="mainImage" alt="main image" src=""/>
                </div>
            </div>           
        </div>

        <p class="clear"></p>

        </table>
        <table id="info">
            <div spry:region="dsGallery" id="album_info">
                <p>Album Name: {sitename}<br />
                    Photographer: {photographer}<br />
                    Date: {@date} </p>  
            </div>
            <!-- image info display-->
            <div id="image_info"></div>
        </table>
        <!-- comment box-->
        <form action="comment.php" method="POST" id="commentbox">
            <table>
                <tr><td colspan="2">Comment Here: </td></tr>
                <tr><td colspan="5"><textarea name="comment" rows="10" cols="50"></textarea></td></tr>
                <tr><td colspan="2"><input type="submit" name="submit" value="Comment" onclick="SetCookieActiveImage();"></td></tr>
            </table>
        </form>
        <!-- comment section-->
        <div id="comment" >
            <?getComments();?>
        </div>
    </body>
</html>
