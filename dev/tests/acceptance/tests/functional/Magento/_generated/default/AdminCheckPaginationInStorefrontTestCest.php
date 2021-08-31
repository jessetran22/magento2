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
 * @Title("MC-6051: Verify that pagination works when Flat Category is enabled")
 * @Description("Login as admin, create flat catalog product and check pagination<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckPaginationInStorefrontTest.xml<br>")
 * @TestCaseId("MC-6051")
 * @group mtf_migrated
 * @group Catalog
 */
class AdminCheckPaginationInStorefrontTestCest
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
		$setFlatCatalogCategory = $I->magentoCLI("config:set catalog/frontend/flat_catalog_category 1 ", 60); // stepKey: setFlatCatalogCategory
		$I->comment($setFlatCatalogCategory);
		$setFlatCatalogProduct = $I->magentoCLI("config:set catalog/frontend/flat_catalog_product 1 ", 60); // stepKey: setFlatCatalogProduct
		$I->comment($setFlatCatalogProduct);
		$I->createEntity("createDefaultCategory", "hook", "_defaultCategory", [], []); // stepKey: createDefaultCategory
		$I->createEntity("simpleProduct1", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct3
		$I->createEntity("simpleProduct4", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct4
		$I->createEntity("simpleProduct5", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct5
		$I->createEntity("simpleProduct6", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct6
		$I->createEntity("simpleProduct7", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct7
		$I->createEntity("simpleProduct8", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct8
		$I->createEntity("simpleProduct9", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct9
		$I->createEntity("simpleProduct10", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct10
		$I->createEntity("simpleProduct11", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct11
		$I->createEntity("simpleProduct12", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct12
		$I->createEntity("simpleProduct13", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct13
		$I->createEntity("simpleProduct14", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct14
		$I->createEntity("simpleProduct15", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct15
		$I->createEntity("simpleProduct16", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct16
		$I->createEntity("simpleProduct17", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct17
		$I->createEntity("simpleProduct18", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct18
		$I->createEntity("simpleProduct19", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct19
		$I->createEntity("simpleProduct20", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct20
		$I->createEntity("simpleProduct21", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct21
		$I->createEntity("simpleProduct22", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct22
		$I->createEntity("simpleProduct23", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct23
		$I->createEntity("simpleProduct24", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct24
		$I->createEntity("simpleProduct25", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct25
		$I->createEntity("simpleProduct26", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct26
		$I->createEntity("simpleProduct27", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct27
		$I->createEntity("simpleProduct28", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct28
		$I->createEntity("simpleProduct29", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct29
		$I->createEntity("simpleProduct30", "hook", "PaginationProduct", [], []); // stepKey: simpleProduct30
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setFlatCatalogCategory = $I->magentoCLI("config:set catalog/frontend/flat_catalog_category 0", 60); // stepKey: setFlatCatalogCategory
		$I->comment($setFlatCatalogCategory);
		$setFlatCatalogProduct = $I->magentoCLI("config:set catalog/frontend/flat_catalog_product 0", 60); // stepKey: setFlatCatalogProduct
		$I->comment($setFlatCatalogProduct);
		$I->deleteEntity("createDefaultCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("simpleProduct5", "hook"); // stepKey: deleteSimpleProduct5
		$I->deleteEntity("simpleProduct6", "hook"); // stepKey: deleteSimpleProduct6
		$I->deleteEntity("simpleProduct7", "hook"); // stepKey: deleteSimpleProduct7
		$I->deleteEntity("simpleProduct8", "hook"); // stepKey: deleteSimpleProduct8
		$I->deleteEntity("simpleProduct9", "hook"); // stepKey: deleteSimpleProduct9
		$I->deleteEntity("simpleProduct10", "hook"); // stepKey: deleteSimpleProduct10
		$I->deleteEntity("simpleProduct11", "hook"); // stepKey: deleteSimpleProduct11
		$I->deleteEntity("simpleProduct12", "hook"); // stepKey: deleteSimpleProduct12
		$I->deleteEntity("simpleProduct13", "hook"); // stepKey: deleteSimpleProduct13
		$I->deleteEntity("simpleProduct14", "hook"); // stepKey: deleteSimpleProduct14
		$I->deleteEntity("simpleProduct15", "hook"); // stepKey: deleteSimpleProduct15
		$I->deleteEntity("simpleProduct16", "hook"); // stepKey: deleteSimpleProduct16
		$I->deleteEntity("simpleProduct17", "hook"); // stepKey: deleteSimpleProduct17
		$I->deleteEntity("simpleProduct18", "hook"); // stepKey: deleteSimpleProduct18
		$I->deleteEntity("simpleProduct19", "hook"); // stepKey: deleteSimpleProduct19
		$I->deleteEntity("simpleProduct20", "hook"); // stepKey: deleteSimpleProduct20
		$I->deleteEntity("simpleProduct21", "hook"); // stepKey: deleteSimpleProduct21
		$I->deleteEntity("simpleProduct22", "hook"); // stepKey: deleteSimpleProduct22
		$I->deleteEntity("simpleProduct23", "hook"); // stepKey: deleteSimpleProduct23
		$I->deleteEntity("simpleProduct24", "hook"); // stepKey: deleteSimpleProduct24
		$I->deleteEntity("simpleProduct25", "hook"); // stepKey: deleteSimpleProduct25
		$I->deleteEntity("simpleProduct26", "hook"); // stepKey: deleteSimpleProduct26
		$I->deleteEntity("simpleProduct27", "hook"); // stepKey: deleteSimpleProduct27
		$I->deleteEntity("simpleProduct28", "hook"); // stepKey: deleteSimpleProduct28
		$I->deleteEntity("simpleProduct29", "hook"); // stepKey: deleteSimpleProduct29
		$I->deleteEntity("simpleProduct30", "hook"); // stepKey: deleteSimpleProduct30
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
	 * @Stories({"Create flat catalog product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckPaginationInStorefrontTest(AcceptanceTester $I)
	{
		$I->comment("Verify default number of products displayed in the grid view");
		$I->comment("Verify default number of products displayed in the grid view");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: goToCatalogConfigPagePage
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageLoad
		$I->conditionalClick("#catalog_frontend-head", "#catalog_frontend_grid_per_page_values", false); // stepKey: openCatalogConfigStorefrontSection
		$I->waitForElementVisible("#catalog_frontend_grid_per_page_values", 30); // stepKey: waitForSectionOpen
		$I->seeInField("#catalog_frontend_grid_per_page_values", "12,24,36"); // stepKey: seeDefaultValueAllowedNumberProductsPerPage
		$I->seeInField("#catalog_frontend_grid_per_page", "12"); // stepKey: seeDefaultValueProductPerPage
		$I->comment("Open Category Page and select created category");
		$I->comment("Open Category Page and select created category");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeClickOnExpandTree
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadClickOnExpandTree
		$I->comment("Exiting Action Group [clickOnExpandTree] AdminExpandCategoryTreeActionGroup");
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: selectCreatedCategory
		$I->waitForPageLoad(30); // stepKey: selectCreatedCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoaded2
		$I->comment("Select Products");
		$I->comment("Select Products");
		$I->scrollTo("div[data-index='assign_products']", 0, -80); // stepKey: scrollToProductInCategory
		$I->waitForPageLoad(30); // stepKey: scrollToProductInCategoryWaitForPageLoad
		$I->click("div[data-index='assign_products']"); // stepKey: clickOnProductInCategory
		$I->waitForPageLoad(30); // stepKey: clickOnProductInCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsToLoad
		$I->scrollTo("//span[contains(text(), 'Reset Filter')]"); // stepKey: scrollToResetFilter
		$I->waitForElementVisible("//span[contains(text(), 'Reset Filter')]", 30); // stepKey: waitForResetButtonToVisible
		$I->click("//span[contains(text(), 'Reset Filter')]"); // stepKey: clickOnResetFilter
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3
		$I->selectOption("#catalog_category_products_page-limit", "30"); // stepKey: selectPagePerView
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProductPerPage
		$I->fillField("#catalog_category_products_filter_name", "pagi"); // stepKey: selectProduct1
		$I->click("//button[@data-action='grid-filter-apply']"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitFroPageToLoad2
		$I->see("30", "#catalog_category_products-total-count"); // stepKey: seeNumberOfProductsFound
		$I->click("input.admin__control-checkbox"); // stepKey: selectSelectAll
		$I->comment("Entering Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageTitleToBeSaved
		$I->comment("Open Category Store Front Page");
		$I->comment("Open Category Store Front Page");
		$I->amOnPage("simplecategory" . msq("_defaultCategory") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoad
		$I->seeElement("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: seeCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: seeCategoryOnNavigationWaitForPageLoad
		$I->click("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->comment("Select 12 items per page and verify number of products displayed in each page");
		$I->comment("Select 12 items per page and verify number of products displayed in each page");
		$I->conditionalClick(".//*[@class='toolbar toolbar-products'][1]//*[@id='mode-grid']", ".//*[@class='toolbar toolbar-products'][1]//*[@id='mode-grid']", true); // stepKey: seeProductGridIsActive
		$I->waitForPageLoad(30); // stepKey: seeProductGridIsActiveWaitForPageLoad
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToBottomToolbarSection
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "12"); // stepKey: selectPerPageOption
		$I->comment("Verify number of products displayed in First Page");
		$I->comment("Verify number of products displayed in First Page");
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInFirstPage
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPageWaitForPageLoad
		$I->comment("Verify number of products displayed in Second Page");
		$I->comment("Verify number of products displayed in Second Page");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButton
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonWaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPage
		$I->waitForPageLoad(30); // stepKey: clickOnNextPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad4
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInSecondPage
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInSecondPageWaitForPageLoad
		$I->comment("Verify number of products displayed in third  Page");
		$I->comment("Verify number of products displayed in third Page");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButton1
		$I->waitForPageLoad(30); // stepKey: scrollToNextButton1WaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPage1
		$I->waitForPageLoad(30); // stepKey: clickOnNextPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2
		$I->seeNumberOfElements("a.product-item-link", "6"); // stepKey: seeNumberOfProductsInThirdPage
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInThirdPageWaitForPageLoad
		$I->comment("Change Pages using Previous Page selector and verify number of products displayed in each page");
		$I->comment("Change Pages using Previous Page selector and verify number of products displayed in each page");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'previous')]"); // stepKey: scrollToPreviousPage
		$I->waitForPageLoad(30); // stepKey: scrollToPreviousPageWaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'previous')]"); // stepKey: clickOnPreviousPage1
		$I->waitForPageLoad(30); // stepKey: clickOnPreviousPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad5
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInSecondPage1
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInSecondPage1WaitForPageLoad
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'previous')]"); // stepKey: scrollToPreviousPage1
		$I->waitForPageLoad(30); // stepKey: scrollToPreviousPage1WaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'previous')]"); // stepKey: clickOnPreviousPage2
		$I->waitForPageLoad(30); // stepKey: clickOnPreviousPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad6
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInFirstPage1
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPage1WaitForPageLoad
		$I->comment("Select Pages by using page Number and verify number of products displayed");
		$I->comment("Select Pages by using page Number and verify number of products displayed");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToPreviousPage2
		$I->waitForPageLoad(30); // stepKey: scrollToPreviousPage2WaitForPageLoad
		$I->click("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'2')]"); // stepKey: clickOnPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad7
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsInSecondPage2
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInSecondPage2WaitForPageLoad
		$I->comment("Select Third Page using page number");
		$I->comment("Select Third Page using page number");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToPreviousPage3
		$I->waitForPageLoad(30); // stepKey: scrollToPreviousPage3WaitForPageLoad
		$I->click("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'3')]"); // stepKey: clickOnThirdPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad8
		$I->seeNumberOfElements("a.product-item-link", "6"); // stepKey: seeNumberOfProductsInThirdPage2
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInThirdPage2WaitForPageLoad
		$I->comment("Select First Page using page number");
		$I->comment("Select First Page using page number");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'previous')]"); // stepKey: scrollToPreviousPage4
		$I->waitForPageLoad(30); // stepKey: scrollToPreviousPage4WaitForPageLoad
		$I->click("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'1')]"); // stepKey: clickOnFirstPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad9
		$I->seeNumberOfElements("a.product-item-link", "12"); // stepKey: seeNumberOfProductsFirstPage2
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsFirstPage2WaitForPageLoad
		$I->comment("Select 24 items per page and verify number of products displayed in each page");
		$I->comment("Select 24 items per page and verify number of products displayed in each page");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToPerPage
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "24"); // stepKey: selectPerPageOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad10
		$I->seeNumberOfElements("a.product-item-link", "24"); // stepKey: seeNumberOfProductsInFirstPage3
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPage3WaitForPageLoad
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButton2
		$I->waitForPageLoad(30); // stepKey: scrollToNextButton2WaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPage2
		$I->waitForPageLoad(30); // stepKey: clickOnNextPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad11
		$I->seeNumberOfElements("a.product-item-link", "6"); // stepKey: seeNumberOfProductsInSecondPage3
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInSecondPage3WaitForPageLoad
		$I->comment("Select First Page using page number");
		$I->comment("Select First Page using page number");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'1')]"); // stepKey: scrollToPreviousPage5
		$I->click("//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'page')]//span[2][contains(text() ,'1')]"); // stepKey: clickOnFirstPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad13
		$I->comment("Select 36 items per page  and verify number of products displayed in each page");
		$I->comment("Select 36 items per page and verify number of products displayed in each page");
		$I->scrollTo("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']"); // stepKey: scrollToPerPage4
		$I->selectOption("//*[@class='toolbar toolbar-products'][2]//select[@id='limiter']", "36"); // stepKey: selectPerPageOption2
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad12
		$I->seeNumberOfElements("a.product-item-link", "30"); // stepKey: seeNumberOfProductsInFirstPage4
		$I->waitForPageLoad(30); // stepKey: seeNumberOfProductsInFirstPage4WaitForPageLoad
	}
}
