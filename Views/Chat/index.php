
<h2>Hello <?php echo $_SESSION['username'];  ?></h2>

<input type="submit" id="logOutBtn" name="userLogout" value="Logout">
<div id="activeUserBox"></div>
<div id="viewChatMessages" style="height : 500px; width: 399px;
    border: 1px black solid;
    overflow: scroll"></div>
<form id="inputText">
<input type="text" id="mainchatText"  placeholder="Say something..">
<input type="submit" id="mainchatBtn" value="send">
</form>