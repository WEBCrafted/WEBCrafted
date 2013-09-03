<?php
if(isset($_SESSION["install"]["jsonapi"])) {
	redirect("admin");
}
elseif(isset($_SESSION["install"]["options"])) {
	redirect("jsonapi");
}
elseif(isset($_SESSION["install"]["database"])) {
	redirect("options");
}
elseif(isset($_SESSION["install"]["requirements"])) {
	redirect("database");
}
redirect("requirements");
