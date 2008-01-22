{include file="header.tpl" noleftindex=true}
<a name="top"></a>
<div class="idx">
	<h2>Full Index</h2>
	<h3>Package Indexes</h3>
</div>

<ul>
	{section name=p loop=$packageindex}
		<li>
			<a href="elementindex_{$packageindex[p].title}.html">{$packageindex[p].title}</a>
		</li>
	{/section}
</ul>
<br />

{include file="basicindex.tpl" indexname="elementindex"}
{include file="footer.tpl"}
