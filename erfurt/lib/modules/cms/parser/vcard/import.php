<?php

// includes
include('../../../../include.php');
include('vcard.php');

if(!empty($_FILES['source']['tmp_name']) && is_uploaded_file($_FILES['source']['tmp_name']))
{

	// parse vcard file 
	$vCard =  new vCard_Import();
	$vCard->setFile($_FILES['source']['tmp_name']);
	
	$adr_class	= $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Content/0.1#Address');
	$vcard_class	= $_ET['rdfsmodel']->getClass('http://powl.sf.net/WCMS/Content/0.1#Staff');

	// address instance for home address
	$adr_instance_home=new $_ET['rdfsmodel']->instance($_ET['rdfsmodel']->getUniqueResourceURI('vCardAddressHome'),$_ET['rdfsmodel']);
	$adr_instance_home->setClass($adr_class);
	$adr_class->addInstance($adr_instance_home);						
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressCity',		$vCard->getHomeCity());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressCountry',	$vCard->getHomeCountry());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressEmail',	$vCard->getEmailPriv());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressFax',		$vCard->getFaxHome());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressMobile',	'');
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressPhone',	$vCard->getTelHome());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressStreet',	$vCard->getHomeStreet());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressURL',		$vCard->getWebsiteHome());
	$adr_instance_home->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressZipcode',	$vCard->getHomeZip());


	// address instance for work address
	$adr_instance_work=new $_ET['rdfsmodel']->instance($_ET['rdfsmodel']->getUniqueResourceURI('vCardAddressWork'),$_ET['rdfsmodel']);
	$adr_instance_work->setClass($adr_class);
	$adr_class->addInstance($adr_instance_work);	
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressCity',		$vCard->getWorkCity());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressCountry',	$vCard->getWorkCountry());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressEmail',	$vCard->getEmail());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressFax',		$vCard->getFaxWork());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressMobile',	$vCard->getCellWork());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressPhone',	$vCard->getTelWork());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressStreet',	$vCard->getWorkStreet());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressURL',		$vCard->getWebsiteWork());
	$adr_instance_work->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#AddressZipcode',	$vCard->getWorkZip());


	// staff instance
	$vcard_instance=new $_ET['rdfsmodel']->instance($_ET['rdfsmodel']->getUniqueResourceURI('vCard'),$_ET['rdfsmodel']);
	$vcard_instance->setClass($vcard_class);
	$vcard_class->addInstance($vcard_instance);
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffAddressHome',	$adr_instance_home);
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffAddressWork',	$adr_instance_work);
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffBirthdate',		$vCard->getBirthday());
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffFirstname',		$vCard->getFirstName());
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffName',		$vCard->getLastName());
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffOpening',		$vCard->getOpening());
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffOrganisation',	$vCard->getCompany());
	$vcard_instance->setPropertyValue('http://powl.sf.net/WCMS/Content/0.1#StaffRole',		$vCard->getRole());


	echo pwl_('vCard Instance added.');

}

?>
<p><b><?= pwl_("vCard File:") ?></b><br />
<form method="post" enctype="multipart/form-data">
<input type="file" value="" name="source" /><br /><br />
<input type="submit" value="<?=pwl_('Submit')?>" onclick="powl.wait(this)" />
</form>
