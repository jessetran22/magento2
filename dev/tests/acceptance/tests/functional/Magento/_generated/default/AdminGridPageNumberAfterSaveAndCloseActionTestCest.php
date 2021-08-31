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
 * @Title("MC-16472: Checking Catalog grid page number after Save and Close action")
 * @Description("Checking Catalog grid page number after Save and Close action<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminGridPageNumberAfterSaveAndCloseActionTest.xml<br>")
 * @TestCaseId("MC-16472")
 * @group Catalog
 */
class AdminGridPageNumberAfterSaveAndCloseActionTestCest
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
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->createEntity("product1", "hook", "SimpleProduct", ["category1"], []); // stepKey: product1
		$I->createEntity("category2", "hook", "SimpleSubCategory", [], []); // stepKey: category2
		$I->createEntity("product2", "hook", "SimpleProduct", ["category2"], []); // stepKey: product2
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
		$I->click("div.admin__data-grid-pager > button.action-previous"); // stepKey: clickPrevPageOrderGrid
		$I->waitForPageLoad(30); // stepKey: clickPrevPageOrderGridWaitForPageLoad
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
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory1
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("category2", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminGridPageNumberAfterSaveAndCloseActionTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductCatalog
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductCatalog
		$I->comment("Exiting Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [select1OrderPerPage] AdminDataGridSelectCustomPerPageActionGroup");
		$I->click(".admin__data-grid-pager-wrap .selectmenu"); // stepKey: clickPerPageDropdownSelect1OrderPerPage
		$I->click("//div[@class='admin__data-grid-pager-wrap']//div[@class='selectmenu-items _active']//li//button[text()='Custom']"); // stepKey: selectCustomPerPageSelect1OrderPerPage
		$I->waitForElementVisible("//div[contains(@class, 'admin__data-grid-pager-wrap')]//div[contains(@class, 'selectmenu-items _active')]//li[contains(@class, '_edit')]//div[contains(@class, 'selectmenu-item-edit')]//input", 30); // stepKey: waitForInputVisibleSelect1OrderPerPage
		$I->fillField("//div[contains(@class, 'admin__data-grid-pager-wrap')]//div[contains(@class, 'selectmenu-items _active')]//li[contains(@class, '_edit')]//div[contains(@class, 'selectmenu-item-edit')]//input", "1"); // stepKey: fillCustomPerPageSelect1OrderPerPage
		$I->click("//div[contains(@class, 'admin__data-grid-pager-wrap')]//div[contains(@class, 'selectmenu-items _active')]//li[@class='_edit']//div[contains(@class, 'selectmenu-item-edit')]//button"); // stepKey: applyCustomPerPageSelect1OrderPerPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForGridLoadSelect1OrderPerPage
		$I->seeInField(".selectmenu-value input", "1"); // stepKey: seePerPageValueInDropDownSelect1OrderPerPage
		$I->waitForPageLoad(30); // stepKey: seePerPageValueInDropDownSelect1OrderPerPageWaitForPageLoad
		$I->comment("Exiting Action Group [select1OrderPerPage] AdminDataGridSelectCustomPerPageActionGroup");
		$I->comment("Go to the next page and edit the product");
		$I->comment("Go to the next page and edit the product");
		$I->click("div.admin__data-grid-pager > button.action-next"); // stepKey: clickNextPageOrderGrid
		$I->waitForPageLoad(30); // stepKey: clickNextPageOrderGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product2', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowOpenEditProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenEditProduct2
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('product2', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageOpenEditProduct2
		$I->comment("Exiting Action Group [openEditProduct2] OpenEditProductOnBackendActionGroup");
		$I->comment("Entering Action Group [saveAndCloseProduct] AdminFormSaveAndCloseActionGroup");
		$I->click("button[data-ui-id='save-button-dropdown']"); // stepKey: openSaveDropDownSaveAndCloseProduct
		$I->waitForPageLoad(30); // stepKey: openSaveDropDownSaveAndCloseProductWaitForPageLoad
		$I->click("span[title='Save & Close']"); // stepKey: clickOnSaveAndCloseSaveAndCloseProduct
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAndCloseSaveAndCloseProductWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: assertSaveMessageSuccessSaveAndCloseProduct
		$I->comment("Exiting Action Group [saveAndCloseProduct] AdminFormSaveAndCloseActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->seeInField("div.admin__data-grid-pager > input[data-ui-id='current-page-input']", "2"); // stepKey: seeOnSecondPageOrderGrid
	}
}
