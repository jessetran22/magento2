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
 * @Title("MAGETWO-92019: Verify Set Product as new Filter input on Product Grid doesn't getreset to currentDate")
 * @Description("Data input in the new from date filter field should not change<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductGridFilteringByDateAttributeTest.xml<br>")
 * @TestCaseId("MAGETWO-92019")
 * @group product
 */
class AdminProductGridFilteringByDateAttributeTestCest
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
		$I->createEntity("createSimpleProductWithDate", "hook", "SimpleProductWithNewFromDate", [], []); // stepKey: createSimpleProductWithDate
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProductWithDate", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Filter products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductGridFilteringByDateAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductAttribute] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageNavigateToProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToProductAttribute
		$I->comment("Exiting Action Group [navigateToProductAttribute] AdminOpenProductAttributePageActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridWaitForPageLoad
		$I->fillField("#attributeGrid_filter_frontend_label", "Set Product as New from Date"); // stepKey: setAttributeLabel
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromGridWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRow
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->click("#advanced_fieldset-wrapper"); // stepKey: openAdvancedPropertiesTab
		$I->selectOption("#is_filterable_in_grid", "Yes"); // stepKey: isFilterableInGrid
		$I->click("#save"); // stepKey: saveAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttribute
		$I->comment("Entering Action Group [clearCache] ClearCacheActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/cache"); // stepKey: goToCacheManagementClearCache
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClearCache
		$I->click("#flush_magento"); // stepKey: clickFlushMagentoCacheClearCache
		$I->waitForPageLoad(30); // stepKey: waitForCacheFlushClearCache
		$I->comment("Exiting Action Group [clearCache] ClearCacheActionGroup");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: openColumnsdropDown1
		$I->checkOption("//div[contains(@class, '_active')]//div[contains(@class, 'admin__data-grid-action-columns-menu')]//div[@class='admin__field-option']//label[text()='Set Product as New from Date']/preceding-sibling::input"); // stepKey: showProductAsNewColumn
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: closeColumnsDropdown1
		$I->seeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Set Product as New from Date']"); // stepKey: seeNewFromDateColumn
		$I->waitForPageLoad(30); // stepKey: seeNewFromDateColumnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitforFiltersToApply
		$I->comment("Entering Action Group [filterProductGridToCheckSetAsNewColumn] FilterProductGridBySetNewFromDateActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridToCheckSetAsNewColumn
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridToCheckSetAsNewColumnWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridToCheckSetAsNewColumn
		$I->fillField("input.admin__control-text[name='news_from_date[from]']", "05/16/2018"); // stepKey: fillSetAsNewProductFilterFilterProductGridToCheckSetAsNewColumn
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridToCheckSetAsNewColumn
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridToCheckSetAsNewColumnWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridToCheckSetAsNewColumn
		$I->comment("Exiting Action Group [filterProductGridToCheckSetAsNewColumn] FilterProductGridBySetNewFromDateActionGroup");
		$I->comment("Entering Action Group [clickOnFirstRowProductGrid] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnFirstRowProductGrid
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnFirstRowProductGrid
		$I->comment("Exiting Action Group [clickOnFirstRowProductGrid] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Entering Action Group [saveAndCloseProductForm] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndCloseProductForm
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndCloseProductFormWaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSaveAndCloseProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSaveAndCloseProductFormWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSaveAndCloseProductForm
		$I->comment("Exiting Action Group [saveAndCloseProductForm] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: expandFilters
		$I->seeInField("input.admin__control-text[name='news_from_date[from]']", "05/16/2018"); // stepKey: checkForNewFromDate
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: openColumnsDropdown2
		$I->uncheckOption("//div[contains(@class, '_active')]//div[contains(@class, 'admin__data-grid-action-columns-menu')]//div[@class='admin__field-option']//label[text()='Set Product as New from Date']/preceding-sibling::input"); // stepKey: hideProductAsNewColumn
		$I->dontSeeElement("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = 'Set Product as New from Date']"); // stepKey: dontSeeNewFromDateColumn
		$I->waitForPageLoad(30); // stepKey: dontSeeNewFromDateColumnWaitForPageLoad
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: closeColumnsDropdown2
		$I->click(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear"); // stepKey: clearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearGridFiltersWaitForPageLoad
	}
}
