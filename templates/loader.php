<?php
if(!Configure::read("install") AND $theme != "install") {
	redirect("install/requirements", false);
}
