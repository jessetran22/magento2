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
 * @Title("MAGETWO-95857: Remove item from cart if product disabled")
 * @Description("Remove item from cart if simple or configurable product is disabled<h3>Test files</h3>app/code/Magento/Quote/Test/Mftf/Test/StorefrontGuestCheckoutDisabledProductTest.xml<br>")
 * @TestCaseId("MAGETWO-95857")
 * @group checkout
 */
class StorefrontGuestCheckoutDisabledProductTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->createEntity("createSimpleProduct2", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct2
		$I->comment("Create the configurable product based on the data in the /data folder");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Make the configurable product have two options, that are children of the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create the 2 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Assign the two products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$setConfigForCartLifetime = $I->magentoCLI("config:set customer/online_customers/section_data_lifetime 1", 60); // stepKey: setConfigForCartLifetime
		$I->comment($setConfigForCartLifetime);
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Entering Action Group [navigateToProductListing] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductListing
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductListing
		$I->comment("Exiting Action Group [navigateToProductListing] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetGridToDefaultKeywordSearch
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearch
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetGridToDefaultKeywordSearchWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetGridToDefaultKeywordSearch
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetGridToDefaultKeywordSearch
		$I->comment("Exiting Action Group [resetGridToDefaultKeywordSearch] ResetProductGridToDefaultViewActionGroup");
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
	 * @Features({"Quote"})
	 * @Stories({"Checkout via the Storefront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontGuestCheckoutDisabledProductTest(AcceptanceTester $I)
	{
		$I->comment("Step 1: Add simple product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToConfigProductPage
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption1', 'value', 'test')); // stepKey: selectOption
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCart
		$I->waitForElement("//main//div[contains(@class, 'messages')]//div[contains(@class, 'message')]/div[contains(text(), 'You added " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to your') and a[contains(., 'shopping cart')]]", 30); // stepKey: assertMessage
		$I->comment("Disabled via admin panel");
		$I->openNewTab(); // stepKey: openNewTab
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Find the first simple product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigChildProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFindCreatedProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct
		$I->comment("Exiting Action Group [findCreatedProduct] FilterProductGridBySkuActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFiltersToBeApplied
		$I->comment("Entering Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage
		$I->comment("Exiting Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Disabled child configurable product");
		$I->click("//span[text()='Enable Product']/parent::label"); // stepKey: clickDisableProduct
		$I->comment("Entering Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->comment("Disabled simple product from grid");
		$I->comment("Entering Action Group [disabledProductFromGrid] ChangeStatusProductUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDisabledProductFromGrid
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDisabledProductFromGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDisabledProductFromGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDisabledProductFromGrid
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDisabledProductFromGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDisabledProductFromGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDisabledProductFromGrid
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDisabledProductFromGrid
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDisabledProductFromGrid
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDisabledProductFromGridWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickChangeStatusActionDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickChangeStatusActionDisabledProductFromGridWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-menu-item')]//ul/li/span[text() = 'Disable']"); // stepKey: clickChangeStatusDisabledDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: waitForStatusToBeChangedDisabledProductFromGrid
		$I->see("A total of 1 record(s) have been updated.", "#messages div.message-success"); // stepKey: seeSuccessMessageDisabledProductFromGrid
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMaskToDisappearDisabledProductFromGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial2DisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitial2DisabledProductFromGridWaitForPageLoad
		$I->comment("Exiting Action Group [disabledProductFromGrid] ChangeStatusProductUsingProductGridActionGroup");
		$I->closeTab(); // stepKey: closeTab
		$I->comment("Check cart");
		$I->wait(60); // stepKey: waitForCartToBeUpdated
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->click("a.showcart"); // stepKey: clickMiniCart
		$I->waitForPageLoad(60); // stepKey: clickMiniCartWaitForPageLoad
		$I->dontSeeElement("span.counter-number"); // stepKey: dontSeeCartItem
		$I->comment("Add simple product to shopping cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage2
		$I->comment("Entering Action Group [cartAddSimpleProductToCart2] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageCartAddSimpleProductToCart2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartAddSimpleProductToCart2
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartAddSimpleProductToCart2
		$I->waitForPageLoad(30); // stepKey: addToCartCartAddSimpleProductToCart2WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddSimpleProductToCart2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddSimpleProductToCart2
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartAddSimpleProductToCart2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartAddSimpleProductToCart2
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddSimpleProductToCart2
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart2] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [goToCheckoutCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCheckoutCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCheckoutCartPage
		$I->comment("Exiting Action Group [goToCheckoutCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Disabled via admin panel");
		$I->openNewTab(); // stepKey: openNewTab2
		$I->comment("Find the first simple product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage2
		$I->comment("Exiting Action Group [visitAdminProductPage2] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [findCreatedProduct2] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedProduct2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterFindCreatedProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedProduct2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedProduct2
		$I->comment("Exiting Action Group [findCreatedProduct2] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [clickOnProductPage2] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage2
		$I->comment("Exiting Action Group [clickOnProductPage2] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Disabled simple product from grid");
		$I->comment("Entering Action Group [disabledProductFromGrid2] ChangeStatusProductUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDisabledProductFromGrid2
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDisabledProductFromGrid2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDisabledProductFromGrid2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDisabledProductFromGrid2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDisabledProductFromGrid2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterDisabledProductFromGrid2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDisabledProductFromGrid2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDisabledProductFromGrid2WaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct2', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDisabledProductFromGrid2
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDisabledProductFromGrid2
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDisabledProductFromGrid2
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDisabledProductFromGrid2
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDisabledProductFromGrid2WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickChangeStatusActionDisabledProductFromGrid2
		$I->waitForPageLoad(30); // stepKey: clickChangeStatusActionDisabledProductFromGrid2WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-menu-item')]//ul/li/span[text() = 'Disable']"); // stepKey: clickChangeStatusDisabledDisabledProductFromGrid2
		$I->waitForPageLoad(30); // stepKey: waitForStatusToBeChangedDisabledProductFromGrid2
		$I->see("A total of 1 record(s) have been updated.", "#messages div.message-success"); // stepKey: seeSuccessMessageDisabledProductFromGrid2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMaskToDisappearDisabledProductFromGrid2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial2DisabledProductFromGrid2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitial2DisabledProductFromGrid2WaitForPageLoad
		$I->comment("Exiting Action Group [disabledProductFromGrid2] ChangeStatusProductUsingProductGridActionGroup");
		$I->closeTab(); // stepKey: closeTab2
		$I->comment("Check cart");
		$I->wait(60); // stepKey: waitForCartToBeUpdated2
		$I->comment("Entering Action Group [reloadPage2] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage2
		$I->comment("Exiting Action Group [reloadPage2] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->click("a.showcart"); // stepKey: clickMiniCart2
		$I->waitForPageLoad(60); // stepKey: clickMiniCart2WaitForPageLoad
		$I->dontSeeElement("span.counter-number"); // stepKey: dontSeeCartItem2
	}
}
