{include file="header.tpl"}

<a name="top"></a>
<div class="idx">
	<h2>[{$package}] Element Index</h2>
	{if count($packageindex) > 1}
		<h3>Package Indexes</h3>
		<ul>
		{section name=p loop=$packageindex}
			{if $packageindex[p].title != $package}
				<li>
					<a href="elementindex_{$packageindex[p].title}.html">{$packageindex[p].title}</a>
				</li>
			{/if}
		{/section}
		</ul>
	{/if}

<a href="elementindex.html">All Elements</a>
<br />
</div>

{include file="basicindex.tpl" indexname=elementindex_$package}
{include file="footer.tpl"}
