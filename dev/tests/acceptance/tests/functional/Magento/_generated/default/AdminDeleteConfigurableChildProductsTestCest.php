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
 * @Title("MC-13684: Configurable Product should not be visible on storefront after child products are deleted")
 * @Description("Login as admin, delete configurable child product and verify product displays out of stock in store front<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminDeleteConfigurableChildProductsTest.xml<br>")
 * @TestCaseId("MC-13684")
 * @group mtf_migrated
 */
class AdminDeleteConfigurableChildProductsTestCest
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
		$I->comment("Set Display Out Of Stock Product");
		$setDisplayOutOfStockProduct = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 0 ", 60); // stepKey: setDisplayOutOfStockProduct
		$I->comment($setDisplayOutOfStockProduct);
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Create Default Category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->comment("Add the attribute just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the first option of the attribute created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Get the second option of the attribute created");
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create Configurable product");
		$I->createEntity("createConfigProduct", "hook", "BaseConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create a simple product and give it the attribute with the first option");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->comment("Create a simple product and give it the attribute with the second option");
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Add the second simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Created Data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteAttribute
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
	 * @Stories({"Configurable Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteConfigurableChildProductsTest(AcceptanceTester $I)
	{
		$I->comment("Open Product in Store Front Page");
		$I->comment("Entering Action Group [openProductInStoreFront] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductInStoreFront
		$I->comment("Exiting Action Group [openProductInStoreFront] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Verify Product is visible and In Stock");
		$I->comment("Entering Action Group [seeCategoryInFrontPage] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPage
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPageWaitForPageLoad
		$I->comment("Exiting Action Group [seeCategoryInFrontPage] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [seeProductNameInStoreFront] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameSeeProductNameInStoreFront
		$I->comment("Exiting Action Group [seeProductNameInStoreFront] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'price', 'test'), ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeProductPriceInStoreFront
		$I->comment("Exiting Action Group [seeProductPriceInStoreFront] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductSkuInStoreFront] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeProductSkuInStoreFront
		$I->comment("Exiting Action Group [seeProductSkuInStoreFront] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductStatusInStoreFront] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->see("In Stock", ".stock[title=Availability]>span"); // stepKey: seeProductStockStatusSeeProductStatusInStoreFront
		$I->comment("Exiting Action Group [seeProductStatusInStoreFront] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductAttributeLabel] AssertStorefrontProductAttributeLabelVisibleActionGroup");
		$I->see($I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test'), "#product-options-wrapper div[tabindex='0'] label"); // stepKey: seeProductAttributeLabelSeeProductAttributeLabel
		$I->comment("Exiting Action Group [seeProductAttributeLabel] AssertStorefrontProductAttributeLabelVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductAttributeOptions] AssertStorefrontProductOptionsDropDownVisibleActionGroup");
		$I->seeElement("#product-options-wrapper div[tabindex='0'] option"); // stepKey: seeProductOptionsDropDownSeeProductAttributeOptions
		$I->comment("Exiting Action Group [seeProductAttributeOptions] AssertStorefrontProductOptionsDropDownVisibleActionGroup");
		$I->comment("Delete Child products");
		$I->comment("Entering Action Group [deleteFirstChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteFirstChildProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteFirstChildProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteFirstChildProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigChildProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteFirstChildProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteFirstChildProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteFirstChildProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteFirstChildProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteFirstChildProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteFirstChildProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteFirstChildProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteFirstChildProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteFirstChildProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteFirstChildProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteFirstChildProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteFirstChildProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteFirstChildProduct
		$I->comment("Exiting Action Group [deleteFirstChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [deleteSecondChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteSecondChildProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteSecondChildProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteSecondChildProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigChildProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteSecondChildProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteSecondChildProductWaitForPageLoad
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteSecondChildProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteSecondChildProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteSecondChildProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteSecondChildProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteSecondChildProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteSecondChildProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteSecondChildProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteSecondChildProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteSecondChildProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteSecondChildProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteSecondChildProduct
		$I->comment("Exiting Action Group [deleteSecondChildProduct] DeleteProductBySkuActionGroup");
		$I->comment("Verify product is not visible in category store front page");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [dontSeeProductInCategoryPage] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'name', 'test') . ".html"); // stepKey: navigateToCategoryPageDontSeeProductInCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadDontSeeProductInCategoryPage
		$I->dontSee($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".product-item-name"); // stepKey: assertProductIsNotPresentDontSeeProductInCategoryPage
		$I->comment("Exiting Action Group [dontSeeProductInCategoryPage] AssertStorefrontProductAbsentOnCategoryPageActionGroup");
		$I->comment("Open Product Store Front Page and Verify Product is Out Of Stock");
		$I->comment("Entering Action Group [openProductInStoreFront1] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductInStoreFront1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductInStoreFront1
		$I->comment("Exiting Action Group [openProductInStoreFront1] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeCategoryInFrontPage1] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->seeElement("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategory', 'name', 'test') . "')]]"); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPage1
		$I->waitForPageLoad(30); // stepKey: seeCatergoryInStoreFrontSeeCategoryInFrontPage1WaitForPageLoad
		$I->comment("Exiting Action Group [seeCategoryInFrontPage1] StorefrontAssertCategoryNameIsShownInMenuActionGroup");
		$I->comment("Entering Action Group [seeProductNameInStoreFront1] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameSeeProductNameInStoreFront1
		$I->comment("Exiting Action Group [seeProductNameInStoreFront1] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->dontSee($I->retrieveEntityField('createConfigProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: dontSeeProductPriceInStoreFront
		$I->comment("Entering Action Group [seeProductSkuInStoreFront1] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see($I->retrieveEntityField('createConfigProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeProductSkuInStoreFront1
		$I->comment("Exiting Action Group [seeProductSkuInStoreFront1] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeProductStatusInStoreFront1] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->see("OUT OF STOCK", ".stock[title=Availability]>span"); // stepKey: seeProductStockStatusSeeProductStatusInStoreFront1
		$I->comment("Exiting Action Group [seeProductStatusInStoreFront1] AssertStorefrontProductStockStatusOnProductPageActionGroup");
		$I->dontSee($I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test'), "#product-options-wrapper div[tabindex='0'] label"); // stepKey: dontSeeProductAttributeLabel
		$I->dontSeeElement("#product-options-wrapper div[tabindex='0'] option"); // stepKey: dontSeeProductAttributeOptions
	}
}
