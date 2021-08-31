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
 * @Title("[NO TESTCASEID]: 'Login as Customer Log' not shown if 'Login as customer' functionality is disabled")
 * @Description("Verify that 'Login as Customer Log' not shown if 'Login as customer' functionality is disabled<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerLogNotShownIfLoginAsCustomerDisabledTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerLogNotShownIfLoginAsCustomerDisabledTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Availability of UI elements if module enable/disable"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerLogNotShownIfLoginAsCustomerDisabledTest(AcceptanceTester $I)
	{
		$I->comment("Verify Login as Customer Log is absent in admin menu");
		$I->comment("Entering Action Group [verifyLoginAsCustomerLogAbsentInMenu] AdminLoginAsCustomerLogAbsentInMenuActionGroup");
		$I->click("li[data-ui-id='menu-magento-customer-customer']"); // stepKey: clickOnCustomersMenuItemVerifyLoginAsCustomerLogAbsentInMenu
		$I->waitForPageLoad(30); // stepKey: clickOnCustomersMenuItemVerifyLoginAsCustomerLogAbsentInMenuWaitForPageLoad
		$I->dontSeeElement("li[data-ui-id='menu-magento-loginascustomer-login-log']"); // stepKey: dontSeeLoginAsCustomerLogVerifyLoginAsCustomerLogAbsentInMenu
		$I->waitForPageLoad(30); // stepKey: dontSeeLoginAsCustomerLogVerifyLoginAsCustomerLogAbsentInMenuWaitForPageLoad
		$I->comment("Exiting Action Group [verifyLoginAsCustomerLogAbsentInMenu] AdminLoginAsCustomerLogAbsentInMenuActionGroup");
		$I->comment("Verify Login as Customer Log is not available by direct url");
		$I->comment("Entering Action Group [verifyLoginAsCustomerLogNotAvailable] AdminLoginAsCustomerLogPageNotAvailableActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: openAdminLoginAsCustomerLogPageVerifyLoginAsCustomerLogNotAvailable
		$I->waitForPageLoad(30); // stepKey: waitForLoginAsCustomerLogPageLoadVerifyLoginAsCustomerLogNotAvailable
		$I->see("404 Error", ".page-content .page-heading"); // stepKey: see404PageHeadingVerifyLoginAsCustomerLogNotAvailable
		$I->comment("Exiting Action Group [verifyLoginAsCustomerLogNotAvailable] AdminLoginAsCustomerLogPageNotAvailableActionGroup");
	}
}
