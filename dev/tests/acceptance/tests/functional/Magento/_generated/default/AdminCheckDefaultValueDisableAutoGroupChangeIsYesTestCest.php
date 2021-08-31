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
 * @Title("[NO TESTCASEID]: Check settings Default Value for Disable Automatic Group Changes Based on VAT ID is Yes")
 * @Description("Check settings Default Value for Disable Automatic Group Changes Based on VAT ID is Yes<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminCheckDefaultValueDisableAutoGroupChangeIsYesTest.xml<br>")
 * @group customer
 * @group create
 */
class AdminCheckDefaultValueDisableAutoGroupChangeIsYesTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$setConfigDefaultIsYes = $I->magentoCLI("config:set customer/create_account/viv_disable_auto_group_assign_default 1", 60); // stepKey: setConfigDefaultIsYes
		$I->comment($setConfigDefaultIsYes);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setConfigDefaultIsNo = $I->magentoCLI("config:set customer/create_account/viv_disable_auto_group_assign_default 0", 60); // stepKey: setConfigDefaultIsNo
		$I->comment($setConfigDefaultIsNo);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Default Value for Disable Automatic Group Changes Based on VAT ID"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckDefaultValueDisableAutoGroupChangeIsYesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewCustomer] AdminNavigateNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/new"); // stepKey: navigateToCustomersNavigateToNewCustomer
		$I->waitForPageLoad(30); // stepKey: waitForLoadNavigateToNewCustomer
		$I->comment("Exiting Action Group [navigateToNewCustomer] AdminNavigateNewCustomerActionGroup");
		$I->comment("Entering Action Group [seeDefaultValueInForm] AdminAssertDefaultValueDisableAutoGroupInCustomerFormActionGroup");
		$grabDisableAutomaticGroupChangeSeeDefaultValueInForm = $I->grabValueFrom("input[name='customer[disable_auto_group_change]']"); // stepKey: grabDisableAutomaticGroupChangeSeeDefaultValueInForm
		$I->assertEquals("1", $grabDisableAutomaticGroupChangeSeeDefaultValueInForm, "pass"); // stepKey: assertDisableAutomaticGroupChangeNoSeeDefaultValueInForm
		$I->comment("Exiting Action Group [seeDefaultValueInForm] AdminAssertDefaultValueDisableAutoGroupInCustomerFormActionGroup");
	}
}
