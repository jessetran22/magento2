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
 * @Title("MC-196: Admin should be able to remove default images from a Configurable Product")
 * @Description("Admin should be able to remove default images from a Configurable Product<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminRemoveDefaultImageConfigurableTest.xml<br>")
 * @TestCaseId("MC-196")
 * @group ConfigurableProduct
 */
class AdminRemoveDefaultImageConfigurableTestCest
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
		$I->createEntity("categoryHandle", "hook", "SimpleSubCategory", [], []); // stepKey: categoryHandle
		$I->createEntity("simple1Handle", "hook", "SimpleProduct", ["categoryHandle"], []); // stepKey: simple1Handle
		$I->createEntity("simple2Handle", "hook", "SimpleProduct", ["categoryHandle"], []); // stepKey: simple2Handle
		$I->comment("TODO: Move configurable product creation to an actionGroup when MQE-697 is fixed");
		$I->createEntity("baseConfigProductHandle", "hook", "BaseConfigurableProduct", ["categoryHandle"], []); // stepKey: baseConfigProductHandle
		$I->createEntity("productAttributeHandle", "hook", "productDropDownAttribute", [], []); // stepKey: productAttributeHandle
		$I->createEntity("productAttributeOption1Handle", "hook", "productAttributeOption1", ["productAttributeHandle"], []); // stepKey: productAttributeOption1Handle
		$I->createEntity("productAttributeOption2Handle", "hook", "productAttributeOption2", ["productAttributeHandle"], []); // stepKey: productAttributeOption2Handle
		$I->createEntity("addToAttributeSetHandle", "hook", "AddToDefaultSet", ["productAttributeHandle"], []); // stepKey: addToAttributeSetHandle
		$I->getEntity("getAttributeOption1Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 1); // stepKey: getAttributeOption1Handle
		$I->getEntity("getAttributeOption2Handle", "hook", "ProductAttributeOptionGetter", ["productAttributeHandle"], null, 2); // stepKey: getAttributeOption2Handle
		$I->createEntity("childProductHandle1", "hook", "SimpleOne", ["productAttributeHandle", "getAttributeOption1Handle"], []); // stepKey: childProductHandle1
		$I->createEntity("childProductHandle2", "hook", "SimpleOne", ["productAttributeHandle", "getAttributeOption2Handle"], []); // stepKey: childProductHandle2
		$I->createEntity("configProductOptionHandle", "hook", "ConfigurableProductTwoOptions", ["baseConfigProductHandle", "productAttributeHandle", "getAttributeOption1Handle", "getAttributeOption2Handle"], []); // stepKey: configProductOptionHandle
		$I->createEntity("configProductHandle1", "hook", "ConfigurableProductAddChild", ["baseConfigProductHandle", "childProductHandle1"], []); // stepKey: configProductHandle1
		$I->createEntity("configProductHandle2", "hook", "ConfigurableProductAddChild", ["baseConfigProductHandle", "childProductHandle2"], []); // stepKey: configProductHandle2
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("simple1Handle", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("simple2Handle", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("childProductHandle1", "hook"); // stepKey: deleteChild1
		$I->deleteEntity("childProductHandle2", "hook"); // stepKey: deleteChild2
		$I->deleteEntity("baseConfigProductHandle", "hook"); // stepKey: deleteConfig
		$I->deleteEntity("categoryHandle", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("productAttributeHandle", "hook"); // stepKey: deleteProductAttribute
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Add/remove images and videos for all product types and category"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRemoveDefaultImageConfigurableTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [productIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadProductIndexPage
		$I->comment("Exiting Action Group [productIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [filterProductGrid] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterProductGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterProductGrid
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('baseConfigProductHandle', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterProductGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterProductGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterProductGridWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterProductGrid
		$I->comment("Exiting Action Group [filterProductGrid] FilterProductGridBySkuActionGroup");
		$I->comment("Entering Action Group [openProducForEditByClickingRow1Column2InProductGrid1] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid1
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProducForEditByClickingRow1Column2InProductGrid1WaitForPageLoad
		$I->comment("Exiting Action Group [openProducForEditByClickingRow1Column2InProductGrid1] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Add image to product");
		$I->comment("Entering Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddImageForProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddImageForProduct
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddImageForProduct
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddImageForProduct
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddImageForProduct
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddImageForProduct
		$I->comment("Exiting Action Group [addImageForProduct] AddProductImageActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Remove image from product");
		$I->comment("Entering Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionRemoveProductImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshRemoveProductImage
		$I->click(".action-remove"); // stepKey: clickRemoveImageRemoveProductImage
		$I->comment("Exiting Action Group [removeProductImage] RemoveProductImageActionGroup");
		$I->comment("Entering Action Group [saveProductFormAfterRemove] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductFormAfterRemove
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormAfterRemoveWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormAfterRemoveWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductFormAfterRemove
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductFormAfterRemove
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductFormAfterRemove
		$I->comment("Exiting Action Group [saveProductFormAfterRemove] SaveProductFormActionGroup");
		$I->comment("Assert product image not in admin product form");
		$I->comment("Entering Action Group [assertProductImageNotInAdminProductPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageNotInAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageNotInAdminProductPage
		$I->dontSeeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageNotInAdminProductPage
		$I->comment("Exiting Action Group [assertProductImageNotInAdminProductPage] AssertProductImageNotInAdminProductPageActionGroup");
		$I->comment("Assert product in storefront product page");
		$I->comment("Entering Action Group [AssertProductInStorefrontProductPageAfterRemove] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('baseConfigProductHandle', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageAssertProductInStorefrontProductPageAfterRemove
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssertProductInStorefrontProductPageAfterRemove
		$I->seeInTitle($I->retrieveEntityField('baseConfigProductHandle', 'name', 'test')); // stepKey: assertProductNameTitleAssertProductInStorefrontProductPageAfterRemove
		$I->see($I->retrieveEntityField('baseConfigProductHandle', 'name', 'test'), ".base"); // stepKey: assertProductNameAssertProductInStorefrontProductPageAfterRemove
		$I->see($I->retrieveEntityField('baseConfigProductHandle', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuAssertProductInStorefrontProductPageAfterRemove
		$I->comment("Exiting Action Group [AssertProductInStorefrontProductPageAfterRemove] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Assert product image not in storefront product page");
		$I->comment("Entering Action Group [assertProductImageNotInStorefrontProductPage2] AssertProductImageNotInStorefrontProductPage2ActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('baseConfigProductHandle', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlAssertProductImageNotInStorefrontProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageNotInStorefrontProductPage2
		$I->dontSeeElement("//*[@class='product media']//img[contains(@src, 'magento-logo')]"); // stepKey: seeImageAssertProductImageNotInStorefrontProductPage2
		$I->comment("Exiting Action Group [assertProductImageNotInStorefrontProductPage2] AssertProductImageNotInStorefrontProductPage2ActionGroup");
	}
}
