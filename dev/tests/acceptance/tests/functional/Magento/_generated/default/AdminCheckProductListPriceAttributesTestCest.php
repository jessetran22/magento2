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
 * @Title("[NO TESTCASEID]: Check price attributes values on Admin Product List.")
 * @Description("Login as admin, create simple product, add cost, special price. Go to Admin                 Product List page filter grid by created product, add mentioned columns to grid, check values.<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckProductListPriceAttributesTest.xml<br>app/code/Magento/Msrp/Test/Mftf/Test/AdminCheckProductListPriceAttributesTest.xml<br>")
 * @group catalog
 * @group msrp
 */
class AdminCheckProductListPriceAttributesTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->createEntity("createSimpleProduct", "hook", "SimpleOutOfStockProductWithSpecialPriceCostAndMsrp", [], []); // stepKey: createSimpleProduct
		$I->comment("Entering Action Group [adminOpenProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAdminOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAdminOpenProductIndexPage
		$I->comment("Exiting Action Group [adminOpenProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProductGridByCreatedSimpleProductSku] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGridByCreatedSimpleProductSku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridByCreatedSimpleProductSkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGridByCreatedSimpleProductSku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'hook')); // stepKey: fillProductSkuFilterFilterProductGridByCreatedSimpleProductSku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGridByCreatedSimpleProductSku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridByCreatedSimpleProductSkuWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGridByCreatedSimpleProductSku
		$I->comment("Exiting Action Group [filterProductGridByCreatedSimpleProductSku] FilterProductGridBySkuActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [clearFiltersAdminProductGrid] ClearFiltersAdminProductGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersClearFiltersAdminProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClearFiltersAdminProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadClearFiltersAdminProductGrid
		$I->comment("Exiting Action Group [clearFiltersAdminProductGrid] ClearFiltersAdminProductGridActionGroup");
		$I->comment("Entering Action Group [openToResetColumnsDropdown] ToggleAdminProductGridColumnsDropdownActionGroup");
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: toggleColumnsDropdownOpenToResetColumnsDropdown
		$I->comment("Exiting Action Group [openToResetColumnsDropdown] ToggleAdminProductGridColumnsDropdownActionGroup");
		$I->comment("Entering Action Group [resetAdminProductGridColumns] ResetAdminProductGridColumnsActionGroup");
		$I->click("//div[contains(@class, '_active')]//div[contains(@class, 'admin__data-grid-action-columns-menu')]//button[text()='Reset']"); // stepKey: resetProductGridColumnsResetAdminProductGridColumns
		$I->comment("Exiting Action Group [resetAdminProductGridColumns] ResetAdminProductGridColumnsActionGroup");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Check price attributes values on Admin Product List"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckProductListPriceAttributesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openColumnsDropdown] ToggleAdminProductGridColumnsDropdownActionGroup");
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: toggleColumnsDropdownOpenColumnsDropdown
		$I->comment("Exiting Action Group [openColumnsDropdown] ToggleAdminProductGridColumnsDropdownActionGroup");
		$I->comment("Entering Action Group [checkSpecialPriceOption] CheckAdminProductGridColumnOptionActionGroup");
		$I->checkOption("//div[contains(@class, '_active')]//div[contains(@class, 'admin__data-grid-action-columns-menu')]//div[@class='admin__field-option']//label[text()='Special Price']/preceding-sibling::input"); // stepKey: checkColumnCheckSpecialPriceOption
		$I->comment("Exiting Action Group [checkSpecialPriceOption] CheckAdminProductGridColumnOptionActionGroup");
		$I->comment("Entering Action Group [checkCostOption] CheckAdminProductGridColumnOptionActionGroup");
		$I->checkOption("//div[contains(@class, '_active')]//div[contains(@class, 'admin__data-grid-action-columns-menu')]//div[@class='admin__field-option']//label[text()='Cost']/preceding-sibling::input"); // stepKey: checkColumnCheckCostOption
		$I->comment("Exiting Action Group [checkCostOption] CheckAdminProductGridColumnOptionActionGroup");
		$I->comment("Entering Action Group [checkMsrpOption] CheckAdminProductGridColumnOptionActionGroup");
		$I->checkOption("//div[contains(@class, '_active')]//div[contains(@class, 'admin__data-grid-action-columns-menu')]//div[@class='admin__field-option']//label[text()='Minimum Advertised Price']/preceding-sibling::input"); // stepKey: checkColumnCheckMsrpOption
		$I->comment("Exiting Action Group [checkMsrpOption] CheckAdminProductGridColumnOptionActionGroup");
		$I->comment("Entering Action Group [closeColumnsDropdown] ToggleAdminProductGridColumnsDropdownActionGroup");
		$I->click(".admin__data-grid-action-columns button.admin__action-dropdown"); // stepKey: toggleColumnsDropdownCloseColumnsDropdown
		$I->comment("Exiting Action Group [closeColumnsDropdown] ToggleAdminProductGridColumnsDropdownActionGroup");
		$I->comment("Entering Action Group [seePrice] AssertAdminProductGridCellActionGroup");
		$I->see("$123.00", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeePrice
		$I->comment("Exiting Action Group [seePrice] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeCorrectSpecialPrice] AssertAdminProductGridCellActionGroup");
		$I->see("$51.51", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Special Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeCorrectSpecialPrice
		$I->comment("Exiting Action Group [seeCorrectSpecialPrice] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeCorrectCost] AssertAdminProductGridCellActionGroup");
		$I->see("$50.05", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Cost']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeCorrectCost
		$I->comment("Exiting Action Group [seeCorrectCost] AssertAdminProductGridCellActionGroup");
		$I->comment("Entering Action Group [seeCorrectMsrp] AssertAdminProductGridCellActionGroup");
		$I->see("$111.11", "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='Minimum Advertised Price']/preceding-sibling::th) +1 ]"); // stepKey: seeProductGridCellWithProvidedValueSeeCorrectMsrp
		$I->comment("Exiting Action Group [seeCorrectMsrp] AssertAdminProductGridCellActionGroup");
	}
}
