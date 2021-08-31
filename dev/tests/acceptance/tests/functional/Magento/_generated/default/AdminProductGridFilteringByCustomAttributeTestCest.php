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
 * @Title("MC-20329: Sorting the product grid by custom product attribute")
 * @Description("Sorting the product grid by custom product attribute should sort Alphabetically instead of value id<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminProductGridFilteringByCustomAttributeTest.xml<br>")
 * @TestCaseId("MC-20329")
 * @group catalog
 */
class AdminProductGridFilteringByCustomAttributeTestCest
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
		$I->comment("Login as admin and delete all products");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteAllProductsUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: openAdminGridProductsPageDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadDeleteAllProducts
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clearGridFiltersDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clearGridFiltersDeleteAllProductsWaitForPageLoad
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", ".data-grid-tr-no-data td", false); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", ".data-grid-tr-no-data td", false); // stepKey: selectAllProductsInGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteAllProducts
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitGridIsEmptyDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteAllProductsUsingProductGridActionGroup");
		$I->comment("Create dropdown product attribute");
		$I->createEntity("createDropdownAttribute", "hook", "productDropDownAttribute", [], []); // stepKey: createDropdownAttribute
		$I->comment("Create attribute options");
		$I->createEntity("createFirstProductAttributeOption", "hook", "ProductAttributeOption7", ["createDropdownAttribute"], []); // stepKey: createFirstProductAttributeOption
		$I->createEntity("createSecondProductAttributeOption", "hook", "ProductAttributeOption8", ["createDropdownAttribute"], []); // stepKey: createSecondProductAttributeOption
		$I->createEntity("createThirdProductAttributeOption", "hook", "ProductAttributeOption9", ["createDropdownAttribute"], []); // stepKey: createThirdProductAttributeOption
		$I->comment("Add attribute to default attribute set");
		$I->createEntity("addAttributeToDefaultSet", "hook", "AddToDefaultSet", ["createDropdownAttribute"], []); // stepKey: addAttributeToDefaultSet
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create 3 products");
		$I->createEntity("createFirstProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createSecondProduct
		$I->createEntity("createThirdProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createThirdProduct
		$I->comment("Update first product");
		$I->comment("Entering Action Group [searchForFirstProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForFirstProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForFirstProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForFirstProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForFirstProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForFirstProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createFirstProduct', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForFirstProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForFirstProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForFirstProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [editFirstProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createFirstProduct', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowEditFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadEditFirstProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createFirstProduct', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageEditFirstProduct
		$I->comment("Exiting Action Group [editFirstProduct] OpenEditProductOnBackendActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createFirstProductAttributeOption', 'option[store_labels][0][label]', 'hook')); // stepKey: setFirstAttributeValue
		$I->comment("Entering Action Group [saveFirstProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveFirstProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveFirstProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveFirstProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveFirstProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveFirstProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveFirstProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveFirstProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveFirstProduct
		$I->comment("Exiting Action Group [saveFirstProduct] SaveProductFormActionGroup");
		$I->comment("Update second product");
		$I->comment("Entering Action Group [searchForSecondProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSecondProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSecondProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSecondProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSecondProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSecondProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createSecondProduct', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSecondProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSecondProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSecondProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [editSecondProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSecondProduct', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowEditSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadEditSecondProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSecondProduct', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageEditSecondProduct
		$I->comment("Exiting Action Group [editSecondProduct] OpenEditProductOnBackendActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createSecondProductAttributeOption', 'option[store_labels][0][label]', 'hook')); // stepKey: setSecondAttributeValue
		$I->comment("Entering Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondProduct
		$I->comment("Exiting Action Group [saveSecondProduct] SaveProductFormActionGroup");
		$I->comment("Update third product");
		$I->comment("Entering Action Group [searchForThirdProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForThirdProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForThirdProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForThirdProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForThirdProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForThirdProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('createThirdProduct', 'sku', 'hook')); // stepKey: fillSkuFieldOnFiltersSectionSearchForThirdProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForThirdProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForThirdProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForThirdProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [editThirdProduct] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createThirdProduct', 'sku', 'hook') . "']]"); // stepKey: clickOnProductRowEditThirdProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadEditThirdProduct
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createThirdProduct', 'sku', 'hook')); // stepKey: seeProductSkuOnEditProductPageEditThirdProduct
		$I->comment("Exiting Action Group [editThirdProduct] OpenEditProductOnBackendActionGroup");
		$I->selectOption("//select[@name='product[" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[attribute_code]', 'hook') . "]']", $I->retrieveEntityField('createThirdProductAttributeOption', 'option[store_labels][0][label]', 'hook')); // stepKey: setThirdAttributeValue
		$I->comment("Entering Action Group [saveThirdProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveThirdProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveThirdProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveThirdProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveThirdProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveThirdProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveThirdProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveThirdProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveThirdProduct
		$I->comment("Exiting Action Group [saveThirdProduct] SaveProductFormActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete products");
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createThirdProduct", "hook"); // stepKey: deleteThirdProduct
		$I->comment("Delete attribute");
		$I->deleteEntity("createDropdownAttribute", "hook"); // stepKey: deleteDropdownAttribute
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [NavigateToAndResetProductGridToDefaultViewAfterTest] NavigateToAndResetProductGridToDefaultViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersNavigateToAndResetProductGridToDefaultViewAfterTestWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewNavigateToAndResetProductGridToDefaultViewAfterTestWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedNavigateToAndResetProductGridToDefaultViewAfterTest
		$I->comment("Exiting Action Group [NavigateToAndResetProductGridToDefaultViewAfterTest] NavigateToAndResetProductGridToDefaultViewActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Product grid"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminProductGridFilteringByCustomAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Sort by custom attribute DESC using grabbed value");
		$I->conditionalClick("//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = '" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[frontend_labels][0][label]', 'test') . "']", "//div[@data-role='grid-wrapper']//table[contains(@class, 'data-grid')]/thead/tr/th[contains(@class, 'data-grid-th')]/span[text() = '" . $I->retrieveEntityField('createDropdownAttribute', 'attribute[frontend_labels][0][label]', 'test') . "']", true); // stepKey: ascendSortByCustomAttribute
		$I->waitForPageLoad(30); // stepKey: ascendSortByCustomAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoad
		$I->comment("Check products sorting. Expected result => Blue-Green-Red");
		$I->see($I->retrieveEntityField('createSecondProduct', 'name', 'test'), "//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "')]"); // stepKey: seeSecondProductName
		$I->waitForPageLoad(30); // stepKey: seeSecondProductNameWaitForPageLoad
		$I->see($I->retrieveEntityField('createFirstProduct', 'name', 'test'), "//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "')]"); // stepKey: seeFirstProductName
		$I->waitForPageLoad(30); // stepKey: seeFirstProductNameWaitForPageLoad
		$I->see($I->retrieveEntityField('createThirdProduct', 'name', 'test'), "//tbody//tr//td//div[contains(., '" . $I->retrieveEntityField('createThirdProduct', 'name', 'test') . "')]"); // stepKey: seeThirdProductName
		$I->waitForPageLoad(30); // stepKey: seeThirdProductNameWaitForPageLoad
	}
}
