<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>{$title}</title>
			<link rel="stylesheet" href="{$subdir}media/stylesheet.css" />
			<link rel="stylesheet" href="{$subdir}media/banner.css" />
			<meta http-equiv='Content-Type' content='text/html; charset=utf8'/>
		</head>
		<body>
			<div class="banner">
				<div class="banner-title">Packages</div>
				<div class="banner-menu">
					{if count($ric) >= 1}
						<ul>
						{assign var="last_ric_name" value=""}
						{section name=ric loop=$ric}
							<li><a href="{$ric[ric].file}" target="right">{$ric[ric].name}</a><li>
							{assign var="last_ric_name" value=$ric[ric].name}
						{/section}
						</ul>
					{/if}
					
					{if count($packages) > 0}
						<ul>
						{assign var="last_package_name" value=""}
						{section name=p loop=$packages}
							<li><a href="{$packages[p].link}" target="left_bottom">{$packages[p].title}</a></li>
							{assign var="last_package_name" value=$packages[p].title}
						{/section}
						</ul>
					{/if}
				</div>
			</div>
		</body>
	</html>