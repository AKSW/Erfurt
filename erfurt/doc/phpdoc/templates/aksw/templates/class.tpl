{include file="header.tpl" top3=true}

<h5 class="package-name">Package: {$package}</h5>
<h2 class="class-name">{if $is_interface}Interface{else}Class{/if} <code>{$class_name}</code></h2>

<pre>{section name=tree loop=$class_tree.classes}{$class_tree.classes[tree]}{$class_tree.distance[tree]}{/section}</pre>

{if $implements}
<p class="implements">
    All Implemented Interfaces:
    <ul class="implements">
        {foreach item="int" from=$implements}<li>{$int}</li>{/foreach}
    </ul>
</p>
{/if}

<a name="sec-description"></a>
<div class="info-box">
	<div class="info-box-title">Description</div>
	<div class="info-box-body">
		{include file="class_docblock.tpl" type="class" sdesc=$sdesc desc=$desc}
		
		{if $tutorial}
			<hr class="separator" />
			<div class="notes">Tutorial: <span class="tutorial">{$tutorial}</span></div>
		{/if}
		
		{if $conflicts.conflict_type}
			<hr class="separator" />
			<div><span class="warning">Conflicts with classes:</span><br /> 
			{section name=me loop=$conflicts.conflicts}
				{$conflicts.conflicts[me]}<br />
			{/section}
			</div>
		{/if}
	</div>
	<div class="nav-bar">
		{if $children || $vars || $ivars || $methods || $imethods || $consts || $iconsts }
			<span class="disabled">Description</span> |
		{/if}
		{if $children}
			<a href="#sec-descendents">Descendents</a>
			{if $vars || $ivars || $methods || $imethods || $consts || $iconsts}|{/if}
		{/if}
		{if $vars || $ivars}
			{if $vars}
				<a href="#sec-var-summary">Vars</a> (<a href="#sec-vars">details</a>)
			{else}
				<a href="#sec-vars">Vars</a>
			{/if}
			{if $methods || $imethods}|{/if}
		{/if}
		{if $methods || $imethods}
			{if $methods}
				<a href="#sec-method-summary">Methods</a> (<a href="#sec-methods">details</a>)
			{else}
				<a href="#sec-methods">Methods</a>
			{/if}			
		{/if}
		{if $consts || $iconsts}
			{if $consts}
				<a href="#sec-const-summary">Constants</a> (<a href="#sec-consts">details</a>)
			{else}
				<a href="#sec-consts">Constants</a>
			{/if}			
		{/if}
	</div>
</div>

{if $children}
	<a name="sec-descendents"></a>
	<div class="info-box">
		<div class="info-box-title">Direct descendents</div>
		<div class="info-box-body">
			<table cellpadding="2" cellspacing="0" class="class-table">
				<tr>
					<th class="class-table-header">Class</th>
					<th class="class-table-header">Description</th>
				</tr>
				{section name=kids loop=$children}
				<tr>
					<td style="padding-right: 2em">{$children[kids].link}</td>
					<td>
					{if $children[kids].sdesc}
						{$children[kids].sdesc}
					{else}
						{$children[kids].desc}
					{/if}
					</td>
				</tr>
				{/section}
			</table>
		</div>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			<span class="disabled">Descendents</span>
			{if $vars || $ivars || $methods || $imethods}|{/if}
			{if $vars || $ivars}
				{if $vars}
					<a href="#sec-var-summary">Vars</a> (<a href="#sec-vars">details</a>)
				{else}
					<a href="#sec-vars">Vars</a>
				{/if}
				{if $methods || $imethods}|{/if}
			{/if}
			{if $methods || $imethods}
				{if $methods}
					<a href="#sec-method-summary">Methods</a> (<a href="#sec-methods">details</a>)
				{else}
					<a href="#sec-methods">Methods</a>
				{/if}			
			{/if}
			{if $consts || $iconsts}
				{if $consts}
					<a href="#sec-const-summary">Constants</a> (<a href="#sec-consts">details</a>)
				{else}
					<a href="#sec-consts">Constants</a>
				{/if}			
			{/if}
		</div>
	</div>
{/if}

{if $consts}
	<a name="sec-const-summary"></a>
	<div class="info-box">
		<div class="info-box-title">Class Constant Summary</span></div>
		<div class="info-box-body">
			<div class="const-summary">
				{section name=consts loop=$consts}
				<div class="const-title">
					<img src="{$subdir}media/images/Constant.png" alt=" " />
					<a href="#{$consts[consts].const_name}" title="details" class="const-name">{$consts[consts].const_name}</a> = 					<span class="var-type">{$consts[consts].const_value}</span>

				</div>
				{/section}
			</div>
		</div>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			{if $children}
				<a href="#sec-descendents">Descendants</a> |
			{/if}
			<span class="disabled">Constants</span> (<a href="#sec-consts">details</a>)
			{if $vars || $ivars}
				{if $vars}
					<a href="#sec-var-summary">Vars</a> (<a href="#sec-vars">details</a>)
				{else}
					<a href="#sec-vars">Vars</a>
				{/if} 
				|
			{/if}
			{if $methods || $imethods}
				| 
				{if $methods}
					<a href="#sec-method-summary">Methods</a> (<a href="#sec-methods">details</a>)
				{else}
					<a href="#sec-methods">Methods</a>
				{/if}			
			{/if}
		</div>
	</div>
{/if}

{if $vars}
	<a name="sec-var-summary"></a>
	<div class="info-box">
		<table class="var-summary" width="100%">
			<tr class="var-summary">
				<th colspan="2" class="var-summary">Variable Summary</th>
			</tr>
			{section name=vars loop=$vars}
			{if $vars[vars].static}
			<tr class="var-summary">
				<td class="var-summary" width="1%">static <span class="var-type">{$vars[vars].var_type}</span></td>
				<td class="var-summary">
					<a href="#{$vars[vars].var_name}" title="details" class="var-name">{$vars[vars].var_name}</a>
				</td>
			</tr>
			{/if}
			{/section}
			
			{section name=vars loop=$vars}
			{if !$vars[vars].static}
			<tr class="var-summary">
				<td class="var-summary" width="1%"><span class="var-type">{$vars[vars].var_type}</span></td>
				<td class="var-summary">
					<a href="#{$vars[vars].var_name}" title="details" class="var-name">{$vars[vars].var_name}</a>
				</td>
			</tr>
			{/if}
			{/section}
		</table>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			{if $children}
				<a href="#sec-descendents">Descendents</a> |
			{/if}
			<span class="disabled">Vars</span> (<a href="#sec-vars">details</a>)
			{if $methods || $imethods}
				| 
				{if $methods}
					<a href="#sec-method-summary">Methods</a> (<a href="#sec-methods">details</a>)
				{else}
					<a href="#sec-methods">Methods</a>
				{/if}			
			{/if}
			{if $consts || $iconsts}
				{if $consts}
					<a href="#sec-const-summary">Constants</a> (<a href="#sec-consts">details</a>)
				{else}
					<a href="#sec-consts">Constants</a>
				{/if}			
			{/if}
		</div>
	</div>
{/if}

{if $methods}
	<a name="sec-method-summary"></a>
	<div class="info-box">
		<table class="var-summary" width="100%">
			<tr class="var-summary">
				<th colspan="2" class="var-summary">Method Summary</th>
			</tr>
			{section name=methods loop=$methods}
			{if $methods[methods].static}
			<tr class="var-summary">
				<td class="var-summary" width="1%">static 
					{if $methods[methods].function_return}
						<span class="method-result">{$methods[methods].function_return}</span>
					{/if}
				</td>
				<td class="var-summary">
					<a href="#{$methods[methods].function_name}" title="details" class="method-name">{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}</a>
					{if count($methods[methods].ifunction_call.params)}
						({section name=params loop=$methods[methods].ifunction_call.params}{if $smarty.section.params.iteration != 1}, {/if}{if $methods[methods].ifunction_call.params[params].hasdefault}[{/if}<span class="var-type">{$methods[methods].ifunction_call.params[params].type}</span>&nbsp;<span class="var-name">{$methods[methods].ifunction_call.params[params].name}</span>{if $methods[methods].ifunction_call.params[params].hasdefault} = <span class="var-default">{$methods[methods].ifunction_call.params[params].default}</span>]
						{/if}{/section})
					{else}
					()
					{/if}
				</td>
			</tr>
			{/if}
			{/section}

			{section name=methods loop=$methods}
			{if !$methods[methods].static}
			<tr class="var-summary">
				<td class="var-summary" width="1%">
					{if $methods[methods].function_return}
						<span class="method-result">{$methods[methods].function_return}</span>
					{/if}
				</td>
				<td class="var-summary">
					<a href="#{$methods[methods].function_name}" title="details" class="method-name">{if $methods[methods].ifunction_call.returnsref}&amp;{/if}{$methods[methods].function_name}</a>
					{if count($methods[methods].ifunction_call.params)}({section name=params loop=$methods[methods].ifunction_call.params}{if $smarty.section.params.iteration != 1}, {/if}{if $methods[methods].ifunction_call.params[params].hasdefault}[{/if}<span class="var-type">{$methods[methods].ifunction_call.params[params].type}</span>&nbsp;<span class="var-name">{$methods[methods].ifunction_call.params[params].name}</span>{if $methods[methods].ifunction_call.params[params].hasdefault} = <span class="var-default">{$methods[methods].ifunction_call.params[params].default}</span>]
						{/if}{/section})
					{else}
					()
					{/if}
				</td>
			</tr>
			{/if}
			{/section}
		</table>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			{if $children}
				<a href="#sec-descendents">Descendents</a> |
			{/if}
			{if $consts || $iconsts}
				{if $consts}
					<a href="#sec-const-summary">Constants</a> (<a href="#sec-consts">details</a>)
				{else}
					<a href="#sec-consts">Constants</a>
				{/if}			
			{/if}
			{if $vars || $ivars}
				{if $vars}
					<a href="#sec-var-summary">Vars</a> (<a href="#sec-vars">details</a>)
				{else}
					<a href="#sec-vars">Vars</a>
				{/if} 
				|
			{/if}
			<span class="disabled">Methods</span> (<a href="#sec-methods">details</a>)
		</div>
	</div>		
{/if}

{if $vars || $ivars}
	<a name="sec-vars"></a>
	<div class="info-box">
		<div class="info-box-title">Variables</div>
		<div class="info-box-body">
			{include file="var.tpl"}
			{if $ivars}
				<h4>Inherited Variables</h4>
				<A NAME='inherited_vars'><!-- --></A>
				{section name=ivars loop=$ivars}
					<p>Inherited from <span class="classname">{$ivars[ivars].parent_class}</span></p>
					<blockquote>
						{section name=ivars2 loop=$ivars[ivars].ivars}
							<span class="var-title">
								<span class="var-name">{$ivars[ivars].ivars[ivars2].link}</span>{if $ivars[ivars].ivars[ivars2].ivar_sdesc}: {$ivars[ivars].ivars[ivars2].ivar_sdesc}{/if}<br>
							</span>
						{/section}
					</blockquote> 
				{/section}
			{/if}			
		</div>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			{if $children}
				<a href="#sec-descendents">Descendents</a> |
			{/if}
			{if $methods}
				<a href="#sec-var-summary">Vars</a> (<span class="disabled">details</span>)
			{else}
				<span class="disabled">Vars</span>
			{/if}			
			
			{if $consts || $iconsts}
				{if $consts}
					<a href="#sec-const-summary">Constants</a> (<a href="#sec-consts">details</a>)
				{else}
					<a href="#sec-consts">Constants</a>
				{/if}			
			{/if}
			{if $methods || $imethods}
				| 
				{if $methods}
					<a href="#sec-method-summary">Methods</a> (<a href="#sec-methods">details</a>)
				{else}
					<a href="#sec-methods">Methods</a>
				{/if}			
			{/if}
		</div>
	</div>
{/if}
	
{if $methods || $imethods}
	<a name="sec-methods"></a>
	<div class="info-box">
		<div class="info-box-title">Methods</div>
		<div class="info-box-body">
			{include file="method.tpl"}
			{if $imethods}
				<h4>Inherited Methods</h4>
				<a name='inherited_methods'><!-- --></a>	
				{section name=imethods loop=$imethods}
					<!-- =========== Summary =========== -->
					<p>Inherited From <span class="classname">{$imethods[imethods].parent_class}</span></p>
					<blockquote>
						{section name=im2 loop=$imethods[imethods].imethods}
							<span class="method-name">{$imethods[imethods].imethods[im2].link}</span>{if $imethods[imethods].imethods[im2].ifunction_sdesc}: {$imethods[imethods].imethods[im2].ifunction_sdesc}{/if}<br>
						{/section}
					</blockquote>
				{/section}
			{/if}			
		</div>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			{if $children}
				<a href="#sec-descendents">Descendents</a> |
			{/if}
			{if $vars || $ivars}
				{if $vars}
					<a href="#sec-var-summary">Vars</a> (<a href="#sec-vars">details</a>)
				{else}
					<a href="#sec-vars">Vars</a>
				{/if}
			{/if}
			{if $consts || $iconsts}
				{if $consts}
					<a href="#sec-const-summary">Constants</a> (<a href="#sec-consts">details</a>)
				{else}
					<a href="#sec-consts">Constants</a>
				{/if}			
			{/if}
			{if $methods}
				<a href="#sec-method-summary">Methods</a> (<span class="disabled">details</span>)
			{else}
				<span class="disabled">Methods</span>
			{/if}			
		</div>
	</div>
{/if}

{if $consts || $iconsts}
	<a name="sec-consts"></a>
	<div class="info-box">
		<div class="info-box-title">Class Constants</div>
		<div class="info-box-body">
			{include file="const.tpl"}
			{if $iconsts}
				<h4>Inherited Constants</h4>
				<A NAME='inherited_vars'><!-- --></A>
				{section name=iconsts loop=$iconsts}
					<p>Inherited from <span class="classname">{$iconsts[iconsts].parent_class}</span></p>
					<blockquote>
						{section name=iconsts2 loop=$iconsts[iconsts].iconsts}
							<img src="{$subdir}media/images/{if $iconsts[iconsts].iconsts[iconsts2].access == 'private'}PrivateVariable{else}Variable{/if}.png" />
							<span class="const-title">
								<span class="const-name">{$iconsts[iconsts].iconsts[iconsts2].link}</span>{if $iconsts[iconsts].iconsts[iconsts2].iconst_sdesc}: {$iconsts[iconsts].iconsts[iconsts2].iconst_sdesc}{/if}<br>
							</span>
						{/section}
					</blockquote> 
				{/section}
			{/if}			
		</div>
		<div class="nav-bar">
			<a href="#sec-description">Description</a> |
			{if $children}
				<a href="#sec-descendents">Descendants</a> |
			{/if}
			{if $methods}
				<a href="#sec-var-summary">Constants</a> (<span class="disabled">details</span>)
			{else}
				<span class="disabled">Constants</span>
			{/if}			
			
			{if $vars || $ivars}
				{if $vars}
					<a href="#sec-var-summary">Vars</a> (<a href="#sec-vars">details</a>)
				{else}
					<a href="#sec-vars">Vars</a>
				{/if}
			{/if}
			{if $methods || $imethods}
				| 
				{if $methods}
					<a href="#sec-method-summary">Methods</a> (<a href="#sec-methods">details</a>)
				{else}
					<a href="#sec-methods">Methods</a>
				{/if}			
			{/if}
		</div>
	</div>
{/if}

{include file="footer.tpl" top3=true}
