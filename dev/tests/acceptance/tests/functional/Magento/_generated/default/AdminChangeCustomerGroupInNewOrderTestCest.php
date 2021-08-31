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
 * @Title("MC-15290: Customer account group cannot be selected while creating a new customer in order")
 * @Description("Customer account group cannot be selected while creating a new customer in order<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminChangeCustomerGroupInNewOrderTest.xml<br>")
 * @TestCaseId("MC-15290")
 * @group sales
 */
class AdminChangeCustomerGroupInNewOrderTestCest
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
	 * @Stories({"MC-15290: Customer account group cannot be selected while creating a new customer in order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminChangeCustomerGroupInNewOrderTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewOrder] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageOpenNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadOpenNewOrder
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleOpenNewOrder
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderOpenNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderOpenNewOrderWaitForPageLoad
		$I->click("#order-customer-selector .actions button.primary"); // stepKey: clickCreateCustomerOpenNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateCustomerOpenNewOrderWaitForPageLoad
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsOpenNewOrder
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsOpenNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectOpenNewOrder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleOpenNewOrder
		$I->comment("Exiting Action Group [openNewOrder] NavigateToNewOrderPageNewCustomerActionGroup");
		$I->selectOption("#group_id", "Retailer"); // stepKey: selectCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$grabGroupValue = $I->grabValueFrom("#group_id"); // stepKey: grabGroupValue
		$I->assertEquals("3", $grabGroupValue); // stepKey: assertValueIsStillSelected
	}
}
