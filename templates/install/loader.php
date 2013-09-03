<?php
if(Configure::read("install")) {
	redirect("home", false);
}
