<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-6441: Country filter on Customers page when allowed countries restriction for a default website is applied")
 * @Description("Country filter on Customers page when allowed countries restriction for a default website is applied<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AllowedCountriesRestrictionApplyOnBackendTest.xml<br>")
 * @TestCaseId("MC-6441")
 * @group customer
 */
class AllowedCountriesRestrictionApplyOnBackendTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create new website,store and store view");
		$I->comment("Create new website,store and store view");
		$I->comment("Entering Action Group [goToAdminSystemStorePage] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreGoToAdminSystemStorePage
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadGoToAdminSystemStorePage
		$I->comment("Exiting Action Group [goToAdminSystemStorePage] AdminSystemStoreOpenPageActionGroup");
		$I->comment("Entering Action Group [adminCreateNewWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageAdminCreateNewWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadAdminCreateNewWebsite
		$I->comment("Create Website");
		$I->fillField("#website_name", "WebSite" . msq("NewWebSiteData")); // stepKey: enterWebsiteNameAdminCreateNewWebsite
		$I->fillField("#website_code", "WebSiteCode" . msq("NewWebSiteData")); // stepKey: enterWebsiteCodeAdminCreateNewWebsite
		$I->click("#save"); // stepKey: clickSaveWebsiteAdminCreateNewWebsite
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteAdminCreateNewWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadAdminCreateNewWebsite
		$I->see("You saved the website."); // stepKey: seeSavedMessageAdminCreateNewWebsite
		$I->comment("Exiting Action Group [adminCreateNewWebsite] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [adminCreateNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Admin creates new Store group");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newGroup"); // stepKey: navigateToNewStoreViewAdminCreateNewStore
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AdminCreateNewStore
		$I->comment("Create Store group");
		$I->selectOption("#group_website_id", "WebSite" . msq("NewWebSiteData")); // stepKey: selectWebsiteAdminCreateNewStore
		$I->fillField("#group_name", "Store" . msq("NewStoreData")); // stepKey: enterStoreGroupNameAdminCreateNewStore
		$I->fillField("#group_code", "StoreCode" . msq("NewStoreData")); // stepKey: enterStoreGroupCodeAdminCreateNewStore
		$I->selectOption("#group_root_category_id", "Default Category"); // stepKey: chooseRootCategoryAdminCreateNewStore
		$I->click("#save"); // stepKey: clickSaveStoreGroupAdminCreateNewStore
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupAdminCreateNewStoreWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadAdminCreateNewStore
		$I->see("You saved the store."); // stepKey: seeSavedMessageAdminCreateNewStore
		$I->comment("Exiting Action Group [adminCreateNewStore] AdminCreateNewStoreGroupActionGroup");
		$I->comment("Entering Action Group [adminCreateNewStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewAdminCreateNewStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AdminCreateNewStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Store" . msq("NewStoreData")); // stepKey: selectStoreAdminCreateNewStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameAdminCreateNewStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeAdminCreateNewStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusAdminCreateNewStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewAdminCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewAdminCreateNewStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalAdminCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalAdminCreateNewStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteAdminCreateNewStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalAdminCreateNewStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalAdminCreateNewStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageAdminCreateNewStoreView
		$I->comment("Exiting Action Group [adminCreateNewStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Set account sharing option - Default value is 'Per Website'");
		$I->comment("Set account sharing option - Default value is 'Per Website'");
		$I->createEntity("setToAccountSharingToDefault", "hook", "CustomerAccountSharingDefault", [], []); // stepKey: setToAccountSharingToDefault
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("delete all created data and set main website country options to default");
		$I->comment("Delete all created data and set main website country options to default");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [deleteTestWebsite] AdminDeleteWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageDeleteTestWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteTestWebsiteWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "WebSite" . msq("NewWebSiteData")); // stepKey: fillSearchWebsiteFieldDeleteTestWebsite
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteTestWebsiteWaitForPageLoad
		$I->see("WebSite" . msq("NewWebSiteData"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteTestWebsite
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingStoreRowDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadDeleteTestWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditWebsitePageDeleteTestWebsiteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteStoreGroupSectionLoadDeleteTestWebsite
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteTestWebsite
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonDeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonDeleteTestWebsiteWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadDeleteTestWebsite
		$I->see("You deleted the website."); // stepKey: seeSavedMessageDeleteTestWebsite
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilter2DeleteTestWebsite
		$I->waitForPageLoad(30); // stepKey: resetSearchFilter2DeleteTestWebsiteWaitForPageLoad
		$I->comment("Exiting Action Group [deleteTestWebsite] AdminDeleteWebsiteActionGroup");
		$I->comment("Entering Action Group [navigateToConfigGeneralPage2] NavigateToConfigurationGeneralPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: navigateToConfigGeneralPageNavigateToConfigGeneralPage2
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageLoadNavigateToConfigGeneralPage2
		$I->comment("Exiting Action Group [navigateToConfigGeneralPage2] NavigateToConfigurationGeneralPageActionGroup");
		$I->comment("Entering Action Group [adminSwitchWebsiteActionGroup] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchWebsiteActionGroup
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchWebsiteActionGroup
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchWebsiteActionGroup
		$I->comment("Exiting Action Group [adminSwitchWebsiteActionGroup] AdminSwitchWebsiteActionGroup");
		$I->comment("Entering Action Group [setCountryOptionsToDefault] SetWebsiteCountryOptionsToDefaultActionGroup");
		$I->conditionalClick("#general_country-head", "#general_country-head.open", false); // stepKey: clickOnStoreInformation3SetCountryOptionsToDefault
		$I->waitForElementVisible("#general_country_destinations", 30); // stepKey: waitCheckboxToBeVisible3SetCountryOptionsToDefault
		$I->checkOption("#general_country_allow_inherit"); // stepKey: setToDefault1SetCountryOptionsToDefault
		$I->checkOption("#general_country_default_inherit"); // stepKey: setToDefault2SetCountryOptionsToDefault
		$I->click("#save"); // stepKey: saveDefaultConfigSetCountryOptionsToDefault
		$I->waitForPageLoad(30); // stepKey: saveDefaultConfigSetCountryOptionsToDefaultWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSystemConfigurationSetCountryOptionsToDefault
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSetCountryOptionsToDefault
		$I->comment("Exiting Action Group [setCountryOptionsToDefault] SetWebsiteCountryOptionsToDefaultActionGroup");
		$I->createEntity("setAccountSharingToSystemValue", "hook", "CustomerAccountSharingSystemValue", [], []); // stepKey: setAccountSharingToSystemValue
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Customer"})
	 * @Stories({"Country filter"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AllowedCountriesRestrictionApplyOnBackendTest(AcceptanceTester $I)
	{
		$I->comment("Check that all countries are allowed initially and get amount");
		$I->comment("Check that all countries are allowed initially and get amount");
		$I->comment("Entering Action Group [navigateToConfigGeneralPage] NavigateToConfigurationGeneralPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: navigateToConfigGeneralPageNavigateToConfigGeneralPage
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageLoadNavigateToConfigGeneralPage
		$I->comment("Exiting Action Group [navigateToConfigGeneralPage] NavigateToConfigurationGeneralPageActionGroup");
		$I->createEntity("setDefaultValueForAllowCountries", "test", "DisableAdminAccountAllowCountry", [], []); // stepKey: setDefaultValueForAllowCountries
		$countriesAmount = $I->executeJS("return document.querySelectorAll('#general_country_allow option').length"); // stepKey: countriesAmount
		$I->comment("Create customer for US");
		$I->comment("Create customer for US");
		$I->createEntity("createCustomer", "test", "Simple_US_CA_Customer", [], []); // stepKey: createCustomer
		$I->comment("Switch to first website, allow only Canada and set Canada as default country");
		$I->comment("Switch to first website, allow only Canada and set Canada as default country");
		$I->comment("Entering Action Group [adminSwitchWebsiteActionGroup] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchWebsiteActionGroup
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchWebsiteActionGroup
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchWebsiteActionGroup
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchWebsiteActionGroupWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchWebsiteActionGroup
		$I->comment("Exiting Action Group [adminSwitchWebsiteActionGroup] AdminSwitchWebsiteActionGroup");
		$I->conditionalClick("#general_country-head", "#general_country-head.open", false); // stepKey: clickOnStoreInformation2
		$I->waitForElementVisible("#general_country_allow", 30); // stepKey: waitAllowedCountriesToBeVisible
		$I->uncheckOption("#general_country_default_inherit"); // stepKey: uncheckCheckbox1
		$I->selectOption("#general_country_default", "Canada"); // stepKey: chooseCanada1
		$I->uncheckOption("#general_country_allow_inherit"); // stepKey: uncheckCheckbox2
		$I->selectOption("#general_country_allow", "Canada"); // stepKey: chooseCanada2
		$I->click("#save"); // stepKey: saveConfig2
		$I->waitForPageLoad(30); // stepKey: saveConfig2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSystemConfiguration2
		$I->comment("Switch to second website and allow all countries except Canada");
		$I->comment("Switch to second website and allow all countries except Canada");
		$I->comment("Entering Action Group [adminSwitchWebsiteActionGroup2] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchWebsiteActionGroup2
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchWebsiteActionGroup2
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchWebsiteActionGroup2
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchWebsiteActionGroup2WaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'WebSite" . msq("NewWebSiteData") . "')]"); // stepKey: clickWebsiteByNameAdminSwitchWebsiteActionGroup2
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchWebsiteActionGroup2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchWebsiteActionGroup2
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchWebsiteActionGroup2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchWebsiteActionGroup2
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchWebsiteActionGroup2WaitForPageLoad
		$I->see("WebSite" . msq("NewWebSiteData"), ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchWebsiteActionGroup2
		$I->comment("Exiting Action Group [adminSwitchWebsiteActionGroup2] AdminSwitchWebsiteActionGroup");
		$I->conditionalClick("#general_country-head", "#general_country-head.open", false); // stepKey: clickOnStoreInformation3
		$I->waitForElementVisible("#general_country_allow", 30); // stepKey: waitAllowedCountriesToBeVisible2
		$I->uncheckOption("#general_country_allow_inherit"); // stepKey: uncheckCheckbox3
		$I->unselectOption("#general_country_allow", "Canada"); // stepKey: unselectCanada
		$I->click("#save"); // stepKey: saveConfig3
		$I->waitForPageLoad(30); // stepKey: saveConfig3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSystemConfiguration3
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createCustomer', 'id', 'test')); // stepKey: goToCustomerEditPage
		$I->waitForPageLoad(30); // stepKey: waitPageToLoad
		$I->comment("Open created customer details page and change US address to Canada address");
		$I->comment("Open created customer details page and change US address to Canada address");
		$I->comment("Entering Action Group [editCustomerAddress] OpenEditCustomerAddressFromAdminActionGroup");
		$I->click("//a//span[contains(text(), 'Addresses')]"); // stepKey: openAddressesTabEditCustomerAddress
		$I->waitForElementVisible("button[data-action='grid-filter-expand']", 30); // stepKey: waitForComponentLoadEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: waitForComponentLoadEditCustomerAddressWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openAddressesFilterEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: openAddressesFilterEditCustomerAddressWaitForPageLoad
		$I->fillField("input[name=firstname]", "John"); // stepKey: fillFirstnameEditCustomerAddress
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastnameEditCustomerAddress
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: fillCountryEditCustomerAddress
		$I->fillField("input[name=postcode]", "90001"); // stepKey: fillPostcodeEditCustomerAddress
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyAddressesFilterEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: applyAddressesFilterEditCustomerAddressWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearEditCustomerAddress
		$I->click("tr[data-repeat-index='0'] .action-select"); // stepKey: clickActionEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: clickActionEditCustomerAddressWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] [data-action='item-edit']"); // stepKey: clickEditEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: clickEditEditCustomerAddressWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForModalWindowEditCustomerAddress
		$I->comment("Exiting Action Group [editCustomerAddress] OpenEditCustomerAddressFromAdminActionGroup");
		$I->selectOption("//*[@class='modal-component']//select[@name='country_id']", "Canada"); // stepKey: selectCountry
		$I->selectOption("//*[@class='modal-component']//select[@name='region_id']", "Quebec"); // stepKey: selectState
		$I->click("//button[@title='Save']"); // stepKey: saveAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSaved
		$I->click("//button[@title='Save and Continue Edit']"); // stepKey: saveCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersPage
		$I->comment("Go to Customers grid and check that filter countries amount is the same as initial allowed countries amount");
		$I->comment("Go to Customers grid and check that filter countries amount is the same as initial allowed countries amount");
		$I->comment("Entering Action Group [goToCustomersGrid] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageGoToCustomersGrid
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCustomersGrid
		$I->comment("Exiting Action Group [goToCustomersGrid] AdminOpenCustomersGridActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomersGrid
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomersGridWaitForPageLoad
		$countriesAmount2 = $I->executeJS("var len = document.querySelectorAll('.admin__data-grid-filters select[name=billing_country_id] option').length; return len-1;"); // stepKey: countriesAmount2
		$I->assertEquals(($countriesAmount), ($countriesAmount2)); // stepKey: assertCountryAmounts
	}
}
