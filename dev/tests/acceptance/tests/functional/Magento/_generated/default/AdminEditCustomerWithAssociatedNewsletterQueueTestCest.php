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
 * @Title("[NO TESTCASEID]: Edit customer if there is associated newsletter queue")
 * @Description("Edit customer if there is associated newsletter queue<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminEditCustomerWithAssociatedNewsletterQueueTest.xml<br>")
 * @group customer
 */
class AdminEditCustomerWithAssociatedNewsletterQueueTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->createEntity("customer", "hook", "Simple_US_Customer_Multiple_Addresses_No_Default_Address", [], []); // stepKey: customer
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [navigateToNewsletterGridPage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToNewsletterGridPage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToNewsletterGridPage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToNewsletterGridPageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-newsletter-newsletter-template']"); // stepKey: clickOnSubmenuItemNavigateToNewsletterGridPage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToNewsletterGridPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToNewsletterGridPage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplateInGrid] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplateInGrid
		$I->fillField("[id$='filter_subject']", "Test Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplateInGrid
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindCreatedNewsletterTemplateInGrid
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindCreatedNewsletterTemplateInGrid
		$I->comment("Exiting Action Group [findCreatedNewsletterTemplateInGrid] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Entering Action Group [openTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->click(".data-grid>tbody>tr"); // stepKey: openTemplateOpenTemplate
		$I->comment("Exiting Action Group [openTemplate] AdminMarketingOpenNewsletterTemplateFromGridActionGroup");
		$I->comment("Entering Action Group [deleteTemplate] AdminMarketingDeleteNewsletterTemplateActionGroup");
		$I->click(".page-actions-inner .page-actions-buttons .delete"); // stepKey: clickDeleteButtonDeleteTemplate
		$I->click(".action-primary.action-accept"); // stepKey: confirmDeleteDeleteTemplate
		$I->waitForPageLoad(10); // stepKey: confirmDeleteDeleteTemplateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingDeleteTemplate
		$I->comment("Exiting Action Group [deleteTemplate] AdminMarketingDeleteNewsletterTemplateActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Edit customer if there is associated newsletter queue"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEditCustomerWithAssociatedNewsletterQueueTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomersGridPageOpenCustomersGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCustomersGridPage
		$I->comment("Exiting Action Group [openCustomersGridPage] AdminOpenCustomersGridActionGroup");
		$I->comment("Entering Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerPage
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerPageWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerPageWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer_Multiple_Addresses_No_Default_Address") . "John.Doe@example.com"); // stepKey: filterEmailOpenEditCustomerPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerPage
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerPage
		$I->comment("Exiting Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Entering Action Group [subscribeToNewsletter] AdminSubscribeCustomerToNewsletters");
		$I->click("//a[@class='admin__page-nav-link' and @id='tab_newsletter_content']"); // stepKey: clickToNewsletterTabHeaderSubscribeToNewsletter
		$I->waitForPageLoad(30); // stepKey: clickToNewsletterTabHeaderSubscribeToNewsletterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShowNewsletterTabSubscribeToNewsletter
		$I->checkOption("//div[@class='admin__field-control control']//input[@name='subscription_status[1]']"); // stepKey: subscribeToNewsletterSubscribeToNewsletter
		$I->click("#save_and_continue"); // stepKey: saveAndContinueSubscribeToNewsletter
		$I->waitForPageLoad(30); // stepKey: saveAndContinueSubscribeToNewsletterWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSubscribeToNewsletter
		$I->see("You saved the customer."); // stepKey: seeSuccessMessageSubscribeToNewsletter
		$I->comment("Exiting Action Group [subscribeToNewsletter] AdminSubscribeCustomerToNewsletters");
		$I->comment("Entering Action Group [navigateToNewsletterTemplatePage] AdminNavigateMenuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoadNavigateToNewsletterTemplatePage
		$I->click("li[data-ui-id='menu-magento-backend-marketing']"); // stepKey: clickOnMenuItemNavigateToNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: clickOnMenuItemNavigateToNewsletterTemplatePageWaitForPageLoad
		$I->click("li[data-ui-id='menu-magento-newsletter-newsletter-template']"); // stepKey: clickOnSubmenuItemNavigateToNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: clickOnSubmenuItemNavigateToNewsletterTemplatePageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToNewsletterTemplatePage] AdminNavigateMenuActionGroup");
		$I->comment("Entering Action Group [navigateToCreateNewsletterTemplatePage] AdminNavigateToCreateNewsletterTemplatePageActionGroup");
		$I->click(".page-actions .page-actions-buttons .add"); // stepKey: clickAddNewTemplateButtonNavigateToCreateNewsletterTemplatePage
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedNavigateToCreateNewsletterTemplatePage
		$I->comment("Exiting Action Group [navigateToCreateNewsletterTemplatePage] AdminNavigateToCreateNewsletterTemplatePageActionGroup");
		$I->comment("Entering Action Group [createNewsletterTemplate] AdminCreateNewsletterTemplateActionGroup");
		$I->comment("Filling All Required Fields");
		$I->fillField("#code", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: fillTemplateNameFieldCreateNewsletterTemplate
		$I->fillField("#subject", "Test Newsletter Subject"); // stepKey: fillTemplateSubjectFieldCreateNewsletterTemplate
		$I->fillField("#sender_name", "Admin"); // stepKey: fillSenderNameFieldCreateNewsletterTemplate
		$I->fillField("#sender_email", "admin@magento.com"); // stepKey: fillSenderEmailFieldCreateNewsletterTemplate
		$I->click(".action-show-hide"); // stepKey: showWYSIWYGCreateNewsletterTemplate
		$I->fillField("textarea", "Some Test Content"); // stepKey: fillTemplateContentFieldCreateNewsletterTemplate
		$I->comment("Saving Created Template");
		$I->click(".page-actions-inner .page-actions-buttons .save"); // stepKey: clickSaveTemplateButtonCreateNewsletterTemplate
		$I->comment("Exiting Action Group [createNewsletterTemplate] AdminCreateNewsletterTemplateActionGroup");
		$I->comment("Entering Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->fillField("[id$='filter_code']", "Test Newsletter Template" . msq("_defaultNewsletter")); // stepKey: filterNameFindCreatedNewsletterTemplate
		$I->fillField("[id$='filter_subject']", "Test Newsletter Subject"); // stepKey: filterSubjectFindCreatedNewsletterTemplate
		$I->click(".action-default.scalable.action-secondary"); // stepKey: clickSearchButtonFindCreatedNewsletterTemplate
		$I->waitForPageLoad(30); // stepKey: waitForNewNewsletterTemplatesPageLoadedAfterFilteringFindCreatedNewsletterTemplate
		$I->comment("Exiting Action Group [findCreatedNewsletterTemplate] AdminSearchNewsletterTemplateOnGridActionGroup");
		$I->comment("Entering Action Group [addNewsletterToQueue] AdminQueueNewsletterActionGroup");
		$I->click(".admin__control-select"); // stepKey: clickActionDropdownAddNewsletterToQueue
		$I->click("//option[contains(text(),'Queue Newsletter')]"); // stepKey: cliclkQueueNewsletterOptionAddNewsletterToQueue
		$I->fillField("#date", "Dec 21, 2022 11:04:20 AM"); // stepKey: setDateAddNewsletterToQueue
		$I->conditionalClick("//option[contains(text(),'Default Store View')]", "//option[contains(text(),'Default Store View')]", true); // stepKey: setStoreviewAddNewsletterToQueue
		$I->click("//span[contains(text(),'Save and Resume')]/ancestor::button"); // stepKey: clickSaveAndResumeButtonAddNewsletterToQueue
		$I->see("You saved the newsletter queue."); // stepKey: seeSuccessMessageAddNewsletterToQueue
		$I->comment("Exiting Action Group [addNewsletterToQueue] AdminQueueNewsletterActionGroup");
		$I->comment("Entering Action Group [editCustomerForm] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1EditCustomerForm
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersEditCustomerFormWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: openFilterEditCustomerFormWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer_Multiple_Addresses_No_Default_Address") . "John.Doe@example.com"); // stepKey: filterEmailEditCustomerForm
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: applyFilterEditCustomerFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2EditCustomerForm
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: clickEditEditCustomerFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3EditCustomerForm
		$I->comment("Exiting Action Group [editCustomerForm] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Entering Action Group [editCustomerAddress] AdminEditCustomerAddressesFromActionGroup");
		$I->click("//span[text()='Addresses']"); // stepKey: proceedToAddressesEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: proceedToAddressesEditCustomerAddressWaitForPageLoad
		$I->click("//span[text()='Add New Address']"); // stepKey: addNewAddressesEditCustomerAddress
		$I->waitForPageLoad(60); // stepKey: wait5678EditCustomerAddress
		$I->fillField("input[name='prefix']", "Mr"); // stepKey: fillPrefixNameEditCustomerAddress
		$I->fillField("input[name='middlename']", "string"); // stepKey: fillMiddleNameEditCustomerAddress
		$I->fillField("input[name='suffix']", "Sr"); // stepKey: fillSuffixNameEditCustomerAddress
		$I->fillField("input[name='company']", "Magento"); // stepKey: fillCompanyEditCustomerAddress
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: fillStreetAddressEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='city']", "Austin"); // stepKey: fillCityEditCustomerAddress
		$I->selectOption("//*[@class='modal-component']//select[@name='country_id']", "US"); // stepKey: selectCountryEditCustomerAddress
		$I->selectOption("//*[@class='modal-component']//select[@name='region_id']", "Texas"); // stepKey: selectStateEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='postcode']", "78729"); // stepKey: fillZipCodeEditCustomerAddress
		$I->fillField("//*[@class='modal-component']//input[@name='telephone']", "1234568910"); // stepKey: fillPhoneEditCustomerAddress
		$I->fillField("input[name='vat_id']", "vatData"); // stepKey: fillVATEditCustomerAddress
		$I->click("//button[@title='Save']"); // stepKey: saveAddressEditCustomerAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSavedEditCustomerAddress
		$I->comment("Exiting Action Group [editCustomerAddress] AdminEditCustomerAddressesFromActionGroup");
		$I->comment("Entering Action Group [saveCustomer] AdminSaveCustomerAndAssertSuccessMessage");
		$I->click("#save"); // stepKey: saveCustomerSaveCustomer
		$I->waitForPageLoad(30); // stepKey: saveCustomerSaveCustomerWaitForPageLoad
		$I->see("You saved the customer", ".message-success"); // stepKey: seeMessageSaveCustomer
		$I->comment("Exiting Action Group [saveCustomer] AdminSaveCustomerAndAssertSuccessMessage");
	}
}
