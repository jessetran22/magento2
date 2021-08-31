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
 * @Title("MAGETWO-30875: Admin should be able to reset customer password")
 * @Description("Admin should be able to reset customer password<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminResetCustomerPasswordTest.xml<br>")
 * @TestCaseId("MAGETWO-30875")
 * @group customer
 */
class AdminResetCustomerPasswordTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
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
	 * @Stories({"Reset password"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminResetCustomerPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Edit customer info");
		$I->comment("Entering Action Group [OpenEditCustomerFrom] OpenEditCustomerFromAdminActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1OpenEditCustomerFrom
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenEditCustomerFromWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFilterOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: openFilterOpenEditCustomerFromWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: filterEmailOpenEditCustomerFrom
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: applyFilterOpenEditCustomerFromWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenEditCustomerFrom
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickEditOpenEditCustomerFrom
		$I->waitForPageLoad(30); // stepKey: clickEditOpenEditCustomerFromWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3OpenEditCustomerFrom
		$I->comment("Exiting Action Group [OpenEditCustomerFrom] OpenEditCustomerFromAdminActionGroup");
		$I->click("#resetPassword"); // stepKey: resetPassword
		$I->waitForPageLoad(30); // stepKey: resetPasswordWaitForPageLoad
		$I->see("The customer will receive an email with a link to reset password."); // stepKey: messageThatLinkToPasswordResetIsSent
	}
}
