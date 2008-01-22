{include file="header.tpl" top1=true}

<!-- Start of Class Data -->
<h2>{$smarty.capture.title}</h2>

<div class="classtree">
{if $interfaces}
	{section name=classtrees loop=$interfaces}
		<h2>Root Interface {$interfaces[classtrees].class}</h2>
		<code>{$interfaces[classtrees].class_tree}</code>
	{/section}
{/if}
</div>

<div class="classtree">
{if $classtrees}
	{section name=classtrees loop=$classtrees}
		<h2>Root Class {$classtrees[classtrees].class}</h2>
		<code>{$classtrees[classtrees].class_tree}</code>
	{/section}
{/if}
</div>

{include file="footer.tpl"}