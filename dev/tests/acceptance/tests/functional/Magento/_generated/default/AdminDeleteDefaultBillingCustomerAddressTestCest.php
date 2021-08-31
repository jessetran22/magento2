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
 * @Title("MAGETWO-94816: Admin delete default billing customer address")
 * @Description("Admin delete default billing customer address<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminDeleteDefaultBillingCustomerAddressTest.xml<br>")
 * @TestCaseId("MAGETWO-94816")
 * @group customer
 */
class AdminDeleteDefaultBillingCustomerAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
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
	 * @Features({"Customer"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Stories({"MAGETWO-94346: Implement handling of large number of addresses on admin edit customer page"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteDefaultBillingCustomerAddressTest(AcceptanceTester $I)
	{
		$I->comment("-
        Step1. Login to admin and go to Customers > All Customers.
        Step2. On *Customers* page choose customer from preconditions and open it to edit
        <!-");
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
		$I->fillField("input[name=email]", msq("Simple_US_Customer_Multiple_Addresses") . "John.Doe@example.com"); // stepKey: filterEmailOpenEditCustomerPage
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerPage
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerPage
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerPage
		$I->comment("Exiting Action Group [openEditCustomerPage] OpenEditCustomerFromAdminActionGroup");
		$I->comment("Step3. Open *Addresses* tab on edit customer page and click *edit* link near *Default Billing Address* block");
		$I->click("//a[@id='tab_address']"); // stepKey: openAddressesTab
		$I->waitForPageLoad(30); // stepKey: openAddressesTabWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickOnButtonToRemoveFiltersIfPresent
		$I->waitForPageLoad(30); // stepKey: clickOnButtonToRemoveFiltersIfPresentWaitForPageLoad
		$I->seeNumberOfElements("//tr[contains(@class,'data-row')]", "2"); // stepKey: seeTwoCustomerAddressesInGrid
		$I->click("//button[@data-index='edit_billing_address']"); // stepKey: clickEditNearDefaultBillingAddress
		$I->waitForPageLoad(30); // stepKey: waitForDefaultBillingAddressPopupLoad
		$I->comment("Step4. Press *Delete* button");
		$I->click("//button[@id='delete']"); // stepKey: clickDeleteButton
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationPopupLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkOnPopup
		$I->waitForPageLoad(30); // stepKey: waitForDefaultBillingAddressPopupLoad2
		$I->seeNumberOfElements("//tr[contains(@class,'data-row')]", "1"); // stepKey: seeOnlyOneCustomerAddressesInGrid
		$I->dontSee("368 Broadway St."); // stepKey: assertDefaultBillingIsSet
	}
}
