<!--[* $Id$ *]-->
<table bgcolor="<!--[$bgcolor2]-->" border="0" cellpadding="5" cellspacing="2" align="center" valign="top" width="99%">
<tr>
<td bgcolor="<!--[$bgcolor2]-->" valign="top" width="100%" colspan="2" align="center" class="pn-title">
<!--[$smarty.const._EZCOMMENTS]-->
</td>
</tr>
<!--[section name=comments loop=$comments]-->
<tr>
<td bgcolor="<!--[$bgcolor4]-->" valign="top" width="20%">
<!--[$comments[comments].uname]--><br>
<!--[$comments[comments].date|date_format:"%d.%m.%y, %H:%M"]-->
</td>
<td bgcolor="<!--[$bgcolor4]-->" valign="top"  width="80%">
<!--[$comments[comments].comment]-->
<!--[if $comments[comments].del]-->
<br />
<form action="<!--[$delurl]-->" method="post">
<input type="hidden" name="authid" id="authid" value="<!--[$authid]-->">
<input type="hidden" name="EZComments_redirect" id="EZComments_redirect" value="<!--[$redirect]-->">
<input type="hidden" name="EZComments_id" id="EZComments_id" value="<!--[$comments[comments].id]-->">
<input type="submit" value="<!--[$smarty.const._EZCOMMENTS_DEL]-->">
</form>
<!--[/if]-->
</tr>
<!--[/section]-->
<!--[if $allowadd]-->
<tr>
<td bgcolor="<!--[$bgcolor4]-->" valign="top">
<!--[$smarty.const._EZCOMMENTS_COMMENT_ADD]-->
</td>
<td bgcolor="<!--[$bgcolor4]-->" valign="top">
<form action="<!--[$addurl]-->" method="post">
<input type="hidden" name="authid" id="authid" value="<!--[$authid]-->">
<input type="hidden" name="EZComments_redirect" id="EZComments_redirect" value="<!--[$redirect]-->">
<input type="hidden" name="EZComments_modname" id="EZComments_modname" value="<!--[$modname]-->">
<input type="hidden" name="EZComments_objectid" id="EZComments_objectid" value="<!--[$objectid]-->">
<textarea name="EZComments_comment" id="EZComments_comment" wrap="soft" cols="80" rows="10">
</textarea><br /><br />
<input type="submit" value="<!--[$smarty.const._EZCOMMENTS_ADD]-->">
</form>
</td>
</tr>
<!--[/if]-->
</table>