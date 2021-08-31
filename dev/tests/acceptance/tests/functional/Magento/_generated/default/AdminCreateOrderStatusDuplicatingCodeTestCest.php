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
 * @Title("MC-15432: Create order status with duplicating code")
 * @Description("Receive error when creating order status with the code which is already exist<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderStatusDuplicatingCodeTest.xml<br>")
 * @TestCaseId("MC-15432")
 * @group sales
 * @group mtf_migrated
 */
class AdminCreateOrderStatusDuplicatingCodeTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
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
	 * @Stories({"Create order status"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderStatusDuplicatingCodeTest(AcceptanceTester $I)
	{
		$I->comment("Go to new order status page");
		$I->comment("Entering Action Group [goToOrderStatusPage] AdminGoToOrderStatusPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_status"); // stepKey: goToOrderStatusPageGoToOrderStatusPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToOrderStatusPage
		$I->comment("Exiting Action Group [goToOrderStatusPage] AdminGoToOrderStatusPageActionGroup");
		$I->comment("Entering Action Group [clickCreateNewStatus] AdminClickCreateNewStatusButtonOnOrderStatusPageActionGroup");
		$I->click("#add"); // stepKey: clickCreateNewStatusClickCreateNewStatus
		$I->waitForPageLoad(30); // stepKey: clickCreateNewStatusClickCreateNewStatusWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickCreateNewStatus
		$I->comment("Exiting Action Group [clickCreateNewStatus] AdminClickCreateNewStatusButtonOnOrderStatusPageActionGroup");
		$I->comment("Fill the form and validate message");
		$I->comment("Entering Action Group [fillFormAndClickSave] AdminOrderStatusFormFillAndSave");
		$I->fillField("#edit_form [name=status]", "pending"); // stepKey: fillStatusCodeFillFormAndClickSave
		$I->fillField("#edit_form [name=label]", "orderLabel" . msq("duplicatingCodeOrderStatus")); // stepKey: fillStatusLabelFillFormAndClickSave
		$I->click("#save"); // stepKey: clickSaveStatusFillFormAndClickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveStatusFillFormAndClickSaveWaitForPageLoad
		$I->comment("Exiting Action Group [fillFormAndClickSave] AdminOrderStatusFormFillAndSave");
		$I->comment("Entering Action Group [seeFormSaveDuplicateError] AssertOrderStatusFormSaveDuplicateError");
		$I->see("We found another order status with the same order status code.", "#messages div.message-error"); // stepKey: seeErrorSeeFormSaveDuplicateError
		$I->comment("Exiting Action Group [seeFormSaveDuplicateError] AssertOrderStatusFormSaveDuplicateError");
	}
}
