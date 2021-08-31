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
 * @Title("MC-16187: Release order in status On Hold")
 * @Description("Release order in status On Hold<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminOrdersReleaseInUnholdStatusTest.xml<br>")
 * @TestCaseId("MC-16187")
 * @group sales
 * @group mtf_migrated
 */
class AdminOrdersReleaseInUnholdStatusTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomerCart", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCart
		$I->createEntity("addCartItemOne", "hook", "CustomerCartItem", ["createCustomerCart", "createProduct"], []); // stepKey: addCartItemOne
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCustomerCart"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCustomerCart", "hook", "CustomerOrderPaymentMethod",["createCustomerCart"]); // stepKey: sendCustomerPaymentInformationOne
		$I->createEntity("holdOrder", "hook", "HoldOrder", ["createCustomerCart"], []); // stepKey: holdOrder
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Mass Update Orders"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminOrdersReleaseInUnholdStatusTest(AcceptanceTester $I)
	{
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [onOrderPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOnOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOnOrderPage
		$I->comment("Exiting Action Group [onOrderPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearFilters
		$I->comment("Exiting Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$grabOrderId = $I->grabTextFrom("//input[@class='admin__control-checkbox' and @value=" . $I->retrieveEntityField('createCustomerCart', 'return', 'test') . "]/parent::label/parent::td/following-sibling::td"); // stepKey: grabOrderId
		$I->comment("Entering Action Group [actionUnold] AdminOrderActionOnGridActionGroup");
		$I->checkOption("//td/div[text()='$grabOrderId']/../preceding-sibling::td//input"); // stepKey: selectOrderActionUnold
		$I->waitForPageLoad(60); // stepKey: selectOrderActionUnoldWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForCheckActionUnold
		$I->click(".action-select-wrap > .action-select"); // stepKey: openActionsActionUnold
		$I->waitForPageLoad(30); // stepKey: openActionsActionUnoldWaitForPageLoad
		$I->click("(//div[contains(@class, 'action-menu-items')]//span[text()='Unhold'])[1]"); // stepKey: selectActionActionUnold
		$I->waitForPageLoad(30); // stepKey: selectActionActionUnoldWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResultsActionUnold
		$I->comment("Exiting Action Group [actionUnold] AdminOrderActionOnGridActionGroup");
		$I->see("1 order(s) have been released from on hold status."); // stepKey: assertOrderReleaseSuccessMessage
		$I->comment("Entering Action Group [seeFirstOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageSeeFirstOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersSeeFirstOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersSeeFirstOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderId); // stepKey: fillOrderIdFilterSeeFirstOrder
		$I->selectOption("select[name='status']", "Pending"); // stepKey: selectOrderStatusSeeFirstOrder
		$I->waitForPageLoad(60); // stepKey: selectOrderStatusSeeFirstOrderWaitForPageLoad
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersSeeFirstOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersSeeFirstOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSeeFirstOrder
		$I->comment("Exiting Action Group [seeFirstOrder] AdminOrderFilterByOrderIdAndStatusActionGroup");
		$I->see($grabOrderId, "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'ID')]/preceding-sibling::th) +1 ]"); // stepKey: assertOrderID
		$I->see("Pending", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Status')]/preceding-sibling::th) +1 ]"); // stepKey: assertOrderStatus
	}
}
