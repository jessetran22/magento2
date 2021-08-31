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
 * @Title("[NO TESTCASEID]: Verify field to filter")
 * @Description("Verify not appear fields to filter on Orders grid if it disables in columns dropdown.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminVerifyFieldToFilterOnOrdersGridTest.xml<br>")
 */
class AdminVerifyFieldToFilterOnOrdersGridTestCest
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
	 * @Features({"Sales"})
	 * @Stories({"Github issue: #28385 Resolve issue with filter visibility with column visibility in grid"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyFieldToFilterOnOrdersGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToOrders] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToOrders
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentGoToOrders
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersGridClearFiltersActionGroup");
		$I->comment("Entering Action Group [unSelectPurchasePoint] AdminSelectFieldToColumnActionGroup");
		$I->click("div.admin__data-grid-action-columns button"); // stepKey: openColumnsDropdownUnSelectPurchasePoint
		$I->waitForPageLoad(30); // stepKey: openColumnsDropdownUnSelectPurchasePointWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-action-columns')]//div[contains(@class, 'admin__field-option')]//label[text() = 'Purchase Point']/preceding-sibling::input"); // stepKey: disableColumnUnSelectPurchasePoint
		$I->click("div.admin__data-grid-action-columns button"); // stepKey: closeColumnsDropdownUnSelectPurchasePoint
		$I->waitForPageLoad(30); // stepKey: closeColumnsDropdownUnSelectPurchasePointWaitForPageLoad
		$I->comment("Exiting Action Group [unSelectPurchasePoint] AdminSelectFieldToColumnActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openColumnsDropdown
		$I->waitForPageLoad(30); // stepKey: openColumnsDropdownWaitForPageLoad
		$I->dontSeeElement(".admin__data-grid-filters select[name='store_id']"); // stepKey: dontSeeElement
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: closeColumnsDropdown
		$I->waitForPageLoad(30); // stepKey: closeColumnsDropdownWaitForPageLoad
		$I->comment("Entering Action Group [selectPurchasePoint] AdminSelectFieldToColumnActionGroup");
		$I->click("div.admin__data-grid-action-columns button"); // stepKey: openColumnsDropdownSelectPurchasePoint
		$I->waitForPageLoad(30); // stepKey: openColumnsDropdownSelectPurchasePointWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-action-columns')]//div[contains(@class, 'admin__field-option')]//label[text() = 'Purchase Point']/preceding-sibling::input"); // stepKey: disableColumnSelectPurchasePoint
		$I->click("div.admin__data-grid-action-columns button"); // stepKey: closeColumnsDropdownSelectPurchasePoint
		$I->waitForPageLoad(30); // stepKey: closeColumnsDropdownSelectPurchasePointWaitForPageLoad
		$I->comment("Exiting Action Group [selectPurchasePoint] AdminSelectFieldToColumnActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openColumnsDropdown2
		$I->waitForPageLoad(30); // stepKey: openColumnsDropdown2WaitForPageLoad
		$I->seeElement(".admin__data-grid-filters select[name='store_id']"); // stepKey: seeElement
	}
}
