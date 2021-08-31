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
 * @Title("MC-39332: Updating the search keyword in admin product grid should reset current page to the first one")
 * @Description("When changing the search keyword in admin product grid, new results should be displayed from the page one<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminGridPageNumberSetsToOneAfterNewSearchTest.xml<br>")
 * @TestCaseId("MC-39332")
 * @group Catalog
 */
class AdminGridPageNumberSetsToOneAfterNewSearchTestCest
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
		$I->comment("Clear product grid");
		$I->comment("Entering Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductCatalog
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductCatalog
		$I->comment("Exiting Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [resetProductGridToDefaultView] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridToDefaultViewWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridToDefaultView
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridToDefaultViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridToDefaultView
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridToDefaultView
		$I->comment("Exiting Action Group [resetProductGridToDefaultView] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [deleteProductIfTheyExist] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteProductIfTheyExist
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteProductIfTheyExist
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProductIfTheyExist
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductIfTheyExistWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProductIfTheyExist
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductIfTheyExistWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteProductIfTheyExist
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteProductIfTheyExistWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProductIfTheyExist
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductIfTheyExistWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteProductIfTheyExist
		$I->comment("Exiting Action Group [deleteProductIfTheyExist] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Create required prerequisites");
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct", ["category1"], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct", ["category1"], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct", ["category1"], []); // stepKey: simpleProduct3
		$I->createEntity("simpleProduct4", "hook", "SimpleProduct", ["category1"], []); // stepKey: simpleProduct4
		$I->createEntity("virtualProduct1", "hook", "VirtualProduct", ["category1"], []); // stepKey: virtualProduct1
		$I->createEntity("virtualProduct2", "hook", "VirtualProduct", ["category1"], []); // stepKey: virtualProduct2
		$I->createEntity("virtualProduct3", "hook", "VirtualProduct", ["category1"], []); // stepKey: virtualProduct3
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductCatalog
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductCatalog
		$I->comment("Exiting Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [deleteCustomAddedPerPage] AdminDataGridDeleteCustomPerPageActionGroup");
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdown1DeleteCustomAddedPerPage
		$I->click("//div[contains(@class, 'selectmenu-items _active')]//div[contains(@class, 'selectmenu-item')]//button[text()='1']/following-sibling::button[contains(@class, 'action-edit')]"); // stepKey: clickToEditCustomPerPageDeleteCustomAddedPerPage
		$I->waitForElementVisible("//div[contains(@class, 'selectmenu-items _active')]//div[contains(@class, 'selectmenu-item')]//button[text()='1']/parent::div/preceding-sibling::div/button[contains(@class, 'action-delete')]", 30); // stepKey: waitForDeleteButtonVisibleDeleteCustomAddedPerPage
		$I->click("//div[contains(@class, 'selectmenu-items _active')]//div[contains(@class, 'selectmenu-item')]//button[text()='1']/parent::div/preceding-sibling::div/button[contains(@class, 'action-delete')]"); // stepKey: clickToDeleteCustomPerPageDeleteCustomAddedPerPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadDeleteCustomAddedPerPage
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdownDeleteCustomAddedPerPage
		$I->dontSeeElement("//*[contains(@class, 'selectmenu-items _active')]//button[contains(@class, 'selectmenu-item-action') and text()='1']"); // stepKey: dontSeeDropDownItemDeleteCustomAddedPerPage
		$I->waitForPageLoad(30); // stepKey: dontSeeDropDownItemDeleteCustomAddedPerPageWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomAddedPerPage] AdminDataGridDeleteCustomPerPageActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFilters
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFilters
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] AdminClearFiltersActionGroup");
		$I->comment("Delete prerequisites");
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("virtualProduct1", "hook"); // stepKey: deleteVirtualProduct1
		$I->deleteEntity("virtualProduct2", "hook"); // stepKey: deleteVirtualProduct2
		$I->deleteEntity("virtualProduct3", "hook"); // stepKey: deleteVirtualProduct3
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory1
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
	 * @Features({"Catalog"})
	 * @Stories({"Catalog grid"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGridPageNumberSetsToOneAfterNewSearchTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductCatalog
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductCatalog
		$I->comment("Exiting Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Set the product grid to display one product per page");
		$I->comment("Entering Action Group [select1ProductPerPage] AdminDataGridSelectCustomPerPageActionGroup");
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdownSelect1ProductPerPage
		$I->click("//div[@class='admin__data-grid-pager-wrap']//div[@class='selectmenu-items _active']//li//button[text()='Custom']"); // stepKey: selectCustomPerPageSelect1ProductPerPage
		$I->waitForElementVisible("//div[contains(@class, 'admin__data-grid-pager-wrap')]//div[contains(@class, 'selectmenu-items _active')]//li[contains(@class, '_edit')]//div[contains(@class, 'selectmenu-item-edit')]//input", 30); // stepKey: waitForInputVisibleSelect1ProductPerPage
		$I->fillField("//div[contains(@class, 'admin__data-grid-pager-wrap')]//div[contains(@class, 'selectmenu-items _active')]//li[contains(@class, '_edit')]//div[contains(@class, 'selectmenu-item-edit')]//input", "1"); // stepKey: fillCustomPerPageSelect1ProductPerPage
		$I->click("//div[contains(@class, 'admin__data-grid-pager-wrap')]//div[contains(@class, 'selectmenu-items _active')]//li[@class='_edit']//div[contains(@class, 'selectmenu-item-edit')]//button"); // stepKey: applyCustomPerPageSelect1ProductPerPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadSelect1ProductPerPage
		$I->seeInField(".selectmenu-value input", "1"); // stepKey: seePerPageValueInDropDownSelect1ProductPerPage
		$I->waitForPageLoad(30); // stepKey: seePerPageValueInDropDownSelect1ProductPerPageWaitForPageLoad
		$I->comment("Exiting Action Group [select1ProductPerPage] AdminDataGridSelectCustomPerPageActionGroup");
		$I->comment("Performing the first search and assertions");
		$I->comment("Entering Action Group [searchForSimpleProduct] AdminSearchGridByStringNoClearActionGroup");
		$I->fillField("input#fulltext", "SimpleProduct"); // stepKey: fillKeywordSearchFieldSearchForSimpleProduct
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchForSimpleProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchForSimpleProduct
		$I->comment("Exiting Action Group [searchForSimpleProduct] AdminSearchGridByStringNoClearActionGroup");
		$I->comment("Entering Action Group [waitForTotalPagesCountFourToBeVisible] AdminGridAssertTotalPageCountActionGroup");
		$I->waitForElementVisible("//div[@class='admin__data-grid-pager']//label[@class='admin__control-support-text' and .='of 4']", 30); // stepKey: waitForTotalPagesCountToBeVisibleWaitForTotalPagesCountFourToBeVisible
		$I->comment("Exiting Action Group [waitForTotalPagesCountFourToBeVisible] AdminGridAssertTotalPageCountActionGroup");
		$I->comment("Entering Action Group [clickNextPageProductGrid] AdminGridGoToNextPageActionGroup");
		$I->click("div.admin__data-grid-pager > button.action-next"); // stepKey: clickNextPageOnGridClickNextPageProductGrid
		$I->waitForPageLoad(30); // stepKey: clickNextPageOnGridClickNextPageProductGridWaitForPageLoad
		$I->comment("Exiting Action Group [clickNextPageProductGrid] AdminGridGoToNextPageActionGroup");
		$I->comment("Entering Action Group [assertCurrentPageIsTwoOnProductGridFirstSearch] AdminGridAssertCurrentPageNumberActionGroup");
		$I->seeInField("div.admin__data-grid-pager > input[data-ui-id='current-page-input']", "2"); // stepKey: seeCurrentPageNumberOnGridAssertCurrentPageIsTwoOnProductGridFirstSearch
		$I->comment("Exiting Action Group [assertCurrentPageIsTwoOnProductGridFirstSearch] AdminGridAssertCurrentPageNumberActionGroup");
		$I->comment("Performing the second search and assertions of successful current page number reset");
		$I->comment("Entering Action Group [searchForVirtualProduct] AdminSearchGridByStringNoClearActionGroup");
		$I->fillField("input#fulltext", "VirtualProduct"); // stepKey: fillKeywordSearchFieldSearchForVirtualProduct
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchForVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchForVirtualProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchForVirtualProduct
		$I->comment("Exiting Action Group [searchForVirtualProduct] AdminSearchGridByStringNoClearActionGroup");
		$I->comment("Entering Action Group [waitForTotalPagesCountThreeToBeVisible] AdminGridAssertTotalPageCountActionGroup");
		$I->waitForElementVisible("//div[@class='admin__data-grid-pager']//label[@class='admin__control-support-text' and .='of 3']", 30); // stepKey: waitForTotalPagesCountToBeVisibleWaitForTotalPagesCountThreeToBeVisible
		$I->comment("Exiting Action Group [waitForTotalPagesCountThreeToBeVisible] AdminGridAssertTotalPageCountActionGroup");
		$I->comment("Entering Action Group [assertCurrentPageIsOneOnProductGridSecondSearch] AdminGridAssertCurrentPageNumberActionGroup");
		$I->seeInField("div.admin__data-grid-pager > input[data-ui-id='current-page-input']", "1"); // stepKey: seeCurrentPageNumberOnGridAssertCurrentPageIsOneOnProductGridSecondSearch
		$I->comment("Exiting Action Group [assertCurrentPageIsOneOnProductGridSecondSearch] AdminGridAssertCurrentPageNumberActionGroup");
	}
}
