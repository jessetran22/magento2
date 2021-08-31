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
 * @Title("MC-5315: Create customer, verify required fields on Addresses tab")
 * @Description("Login as admin and verify required fields on Address tab<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminVerifyCustomerAddressRequiredFieldsTest.xml<br>")
 * @TestCaseId("MC-5315")
 * @group mtf_migrated
 */
class AdminVerifyCustomerAddressRequiredFieldsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Create customer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyCustomerAddressRequiredFieldsTest(AcceptanceTester $I)
	{
		$I->comment("Open Created Customer");
		$I->comment("Entering Action Group [editCustomerForm] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1EditCustomerForm
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersEditCustomerFormWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: openFilterEditCustomerFormWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_Customer_Without_Address") . "John.Doe@example.com"); // stepKey: filterEmailEditCustomerForm
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: applyFilterEditCustomerFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2EditCustomerForm
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditEditCustomerForm
		$I->waitForPageLoad(30); // stepKey: clickEditEditCustomerFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3EditCustomerForm
		$I->comment("Exiting Action Group [editCustomerForm] OpenEditCustomerFromAdminActionGroup");
		$I->click("//a//span[contains(text(), 'Addresses')]"); // stepKey: openAddressesTab
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->click("//span[text()='Add New Address']"); // stepKey: ClickOnAddNewAddressButton
		$I->waitForPageLoad(30); // stepKey: waitForAdressPageToLoad
		$I->click("//button[@title='Save']"); // stepKey: clickOnSaveButton
		$I->waitForPageLoad(30); // stepKey: waitForPageToBeSaved
		$I->comment("Assert Required Field Messages");
		$I->seeElement("//input[@name='street[0]']/../label[contains(.,'This is a required field.')]"); // stepKey: seeStreetRequiredMessage
		$I->seeElement("//input[@name='city']/../label[contains(.,'This is a required field.')]"); // stepKey: seeCityRequiredMessage
		$I->scrollTo("//*[@class='modal-component']//input[@name='telephone']", 0, -80); // stepKey: scrollToPhone
		$I->seeElement("//select[@name='country_id']/../label[contains(.,'This is a required field.')]"); // stepKey: seeCountryRequiredMessage
		$I->seeElement("//input[@name='postcode']/../label[contains(.,'This is a required field.')]"); // stepKey: seePostcodeRequiredMessage
		$I->seeElement("//input[@name='telephone']/../label[contains(.,'This is a required field.')]"); // stepKey: seePhoneNumberRequiredMessage
	}
}
