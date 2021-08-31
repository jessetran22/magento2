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
 * @Title("[NO TESTCASEID]: Check thumbnail images and active image for Configurable Product")
 * @Description("Login as admin, create attribute with two options, configurable product with two                 associated simple products. Add few images for products, check the fotorama thumbnail images                 (visible and active) for each selected option for the configurable product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontConfigurableOptionsThumbImagesTest.xml<br>")
 * @group catalog
 */
class StorefrontConfigurableOptionsThumbImagesTestCest
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
		$I->comment("ConfigProduct");
		$I->comment("Go to Product Page (ConfigProduct)");
		$I->comment("Entering Action Group [goToConfigProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigProduct', 'id', 'hook')); // stepKey: goToProductGoToConfigProduct
		$I->comment("Exiting Action Group [goToConfigProduct] AdminProductPageOpenByIdActionGroup");
		$I->comment("Switch to 'Default Store View' scope and open product page");
		$I->comment("Entering Action Group [SwitchDefaultStoreViewForConfigProduct] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchDefaultStoreViewForConfigProduct
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewForConfigProduct
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewForConfigProductWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewForConfigProduct
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewForConfigProductWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Default Store View']"); // stepKey: chooseStoreViewSwitchDefaultStoreViewForConfigProduct
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchDefaultStoreViewForConfigProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewForConfigProduct
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewForConfigProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchDefaultStoreViewForConfigProduct
		$I->comment("Exiting Action Group [SwitchDefaultStoreViewForConfigProduct] SwitchToTheNewStoreViewActionGroup");
		$I->comment("Add images for ConfigProduct");
		$I->comment("Entering Action Group [addConfigProductMagento3] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddConfigProductMagento3
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddConfigProductMagento3
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddConfigProductMagento3
		$I->attachFile("#fileupload", "magento3.jpg"); // stepKey: uploadFileAddConfigProductMagento3
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddConfigProductMagento3
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento3')]", 30); // stepKey: waitForThumbnailAddConfigProductMagento3
		$I->comment("Exiting Action Group [addConfigProductMagento3] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addConfigProductTestImageAdobe] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddConfigProductTestImageAdobe
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddConfigProductTestImageAdobe
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddConfigProductTestImageAdobe
		$I->attachFile("#fileupload", "adobe-base.jpg"); // stepKey: uploadFileAddConfigProductTestImageAdobe
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddConfigProductTestImageAdobe
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: waitForThumbnailAddConfigProductTestImageAdobe
		$I->comment("Exiting Action Group [addConfigProductTestImageAdobe] AddProductImageActionGroup");
		$I->comment("Entering Action Group [assignTestImageAdobeBaseRole] AdminAssignImageBaseRoleActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", false); // stepKey: expandImagesAssignTestImageAdobeBaseRole
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeProductImageNameAssignTestImageAdobeBaseRole
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]"); // stepKey: clickProductImageAssignTestImageAdobeBaseRole
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignTestImageAdobeBaseRole
		$I->checkOption("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']"); // stepKey: checkRolesAssignTestImageAdobeBaseRole
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignTestImageAdobeBaseRole
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignTestImageAdobeBaseRoleWaitForPageLoad
		$I->comment("Exiting Action Group [assignTestImageAdobeBaseRole] AdminAssignImageBaseRoleActionGroup");
		$I->comment("Save changes fot ConfigProduct");
		$I->comment("Entering Action Group [saveConfigProductProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigProductProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigProductProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigProductProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigProductProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigProductProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigProductProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigProductProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigProductProduct
		$I->comment("Exiting Action Group [saveConfigProductProduct] SaveProductFormActionGroup");
		$I->comment("ChildProduct1");
		$I->comment("Go to Product Page (ChildProduct1)");
		$I->comment("Entering Action Group [goToChildProduct1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'hook')); // stepKey: goToProductGoToChildProduct1
		$I->comment("Exiting Action Group [goToChildProduct1] AdminProductPageOpenByIdActionGroup");
		$I->comment("Switch to 'Default Store View' scope and open product page");
		$I->comment("Entering Action Group [SwitchDefaultStoreViewForChildProduct1] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchDefaultStoreViewForChildProduct1
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewForChildProduct1
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewForChildProduct1WaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewForChildProduct1
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewForChildProduct1WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Default Store View']"); // stepKey: chooseStoreViewSwitchDefaultStoreViewForChildProduct1
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchDefaultStoreViewForChildProduct1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewForChildProduct1
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewForChildProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchDefaultStoreViewForChildProduct1
		$I->comment("Exiting Action Group [SwitchDefaultStoreViewForChildProduct1] SwitchToTheNewStoreViewActionGroup");
		$I->comment("Add images for ChildProduct1");
		$I->comment("Entering Action Group [addChildProduct1ProductImage] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddChildProduct1ProductImage
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddChildProduct1ProductImage
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddChildProduct1ProductImage
		$I->attachFile("#fileupload", "magento-logo.png"); // stepKey: uploadFileAddChildProduct1ProductImage
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddChildProduct1ProductImage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: waitForThumbnailAddChildProduct1ProductImage
		$I->comment("Exiting Action Group [addChildProduct1ProductImage] AddProductImageActionGroup");
		$I->comment("Entering Action Group [addChildProduct1Magento2] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddChildProduct1Magento2
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddChildProduct1Magento2
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddChildProduct1Magento2
		$I->attachFile("#fileupload", "magento2.jpg"); // stepKey: uploadFileAddChildProduct1Magento2
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddChildProduct1Magento2
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento2')]", 30); // stepKey: waitForThumbnailAddChildProduct1Magento2
		$I->comment("Exiting Action Group [addChildProduct1Magento2] AddProductImageActionGroup");
		$I->comment("Entering Action Group [assignMagento2Role] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "//*[@id='media_gallery_content']//img[contains(@src, 'magento2')]", false); // stepKey: expandImagesAssignMagento2Role
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento2')]", 30); // stepKey: seeProductImageNameAssignMagento2Role
		$I->click("//*[@id='media_gallery_content']//img[contains(@src, 'magento2')]"); // stepKey: clickProductImageAssignMagento2Role
		$I->waitForElementVisible("textarea[data-role='image-description']", 30); // stepKey: seeAltTextSectionAssignMagento2Role
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Base']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleBaseAssignMagento2Role
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Small']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSmallAssignMagento2Role
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Thumbnail']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleThumbnailAssignMagento2Role
		$I->conditionalClick("//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']", "//div[contains(@class, 'field-image-role')]//ul/li/label[normalize-space(.) = 'Swatch']/parent::li[contains(@class,'selected')]", false); // stepKey: checkRoleSwatchAssignMagento2Role
		$I->click(".modal-slide._show [data-role=\"closeBtn\"]"); // stepKey: clickCloseButtonAssignMagento2Role
		$I->waitForPageLoad(30); // stepKey: clickCloseButtonAssignMagento2RoleWaitForPageLoad
		$I->comment("Exiting Action Group [assignMagento2Role] AdminAssignImageRolesIfUnassignedActionGroup");
		$I->comment("Save changes fot ChildProduct1");
		$I->comment("Entering Action Group [saveChildProduct1Product] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveChildProduct1Product
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveChildProduct1Product
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveChildProduct1ProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveChildProduct1Product
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveChildProduct1ProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveChildProduct1Product
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveChildProduct1Product
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveChildProduct1Product
		$I->comment("Exiting Action Group [saveChildProduct1Product] SaveProductFormActionGroup");
		$I->comment("ChildProduct2");
		$I->comment("Go to Product Page (ChildProduct2)");
		$I->comment("Entering Action Group [goToChildProduct2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'hook')); // stepKey: goToProductGoToChildProduct2
		$I->comment("Exiting Action Group [goToChildProduct2] AdminProductPageOpenByIdActionGroup");
		$I->comment("Switch to 'Default Store View' scope and open product page");
		$I->comment("Entering Action Group [SwitchDefaultStoreViewForChildProduct2] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchDefaultStoreViewForChildProduct2
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewForChildProduct2
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchDefaultStoreViewForChildProduct2WaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewForChildProduct2
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchDefaultStoreViewForChildProduct2WaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='Default Store View']"); // stepKey: chooseStoreViewSwitchDefaultStoreViewForChildProduct2
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchDefaultStoreViewForChildProduct2WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewForChildProduct2
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchDefaultStoreViewForChildProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchDefaultStoreViewForChildProduct2
		$I->comment("Exiting Action Group [SwitchDefaultStoreViewForChildProduct2] SwitchToTheNewStoreViewActionGroup");
		$I->comment("Add image for ChildProduct2");
		$I->comment("Entering Action Group [addChildProduct2TestImageNew] AddProductImageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAddChildProduct2TestImageNew
		$I->waitForPageLoad(30); // stepKey: waitForPageRefreshAddChildProduct2TestImageNew
		$I->waitForElementVisible("div.image div.fileinput-button", 30); // stepKey: seeImageSectionIsReadyAddChildProduct2TestImageNew
		$I->attachFile("#fileupload", "magento-again.jpg"); // stepKey: uploadFileAddChildProduct2TestImageNew
		$I->waitForElementNotVisible(".uploader .file-row", 30); // stepKey: waitForUploadAddChildProduct2TestImageNew
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-again')]", 30); // stepKey: waitForThumbnailAddChildProduct2TestImageNew
		$I->comment("Exiting Action Group [addChildProduct2TestImageNew] AddProductImageActionGroup");
		$I->comment("Save changes fot ChildProduct2");
		$I->comment("Entering Action Group [saveChildProduct2Product] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveChildProduct2Product
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveChildProduct2Product
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveChildProduct2ProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveChildProduct2Product
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveChildProduct2ProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveChildProduct2Product
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveChildProduct2Product
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveChildProduct2Product
		$I->comment("Exiting Action Group [saveChildProduct2Product] SaveProductFormActionGroup");
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
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableOptionsThumbImagesTest(AcceptanceTester $I)
	{
		$I->comment("Open ConfigProduct in Store Front Page");
		$I->amOnPage($I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductInStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoad
		$I->comment("Check fotorama thumbnail images (no selected options)");
		$I->comment("Entering Action Group [seeMagento3ForNoOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento3']"); // stepKey: seeActiveImageDefaultSeeMagento3ForNoOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeMagento3ForNoOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeMagento3ForNoOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [seeActiveTestImageAdobeForNoOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='adobe-base']"); // stepKey: seeActiveImageDefaultSeeActiveTestImageAdobeForNoOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeActiveTestImageAdobeForNoOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeActiveTestImageAdobeForNoOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Select first option");
		$I->comment("Entering Action Group [selectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectFirstOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectFirstOptionValue
		$I->comment("Exiting Action Group [selectFirstOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Check fotorama thumbnail images (first option selected)");
		$I->comment("Entering Action Group [seeMagento3ForFirstOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento3']"); // stepKey: seeActiveImageDefaultSeeMagento3ForFirstOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeMagento3ForFirstOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeMagento3ForFirstOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [seeTestImageAdobeForFirstOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='adobe-base']"); // stepKey: seeActiveImageDefaultSeeTestImageAdobeForFirstOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeTestImageAdobeForFirstOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeTestImageAdobeForFirstOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [seeProductImageForFirstOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento-logo']"); // stepKey: seeActiveImageDefaultSeeProductImageForFirstOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeProductImageForFirstOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeProductImageForFirstOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Check active fotorama thumbnail image (first option selected)");
		$I->comment("Entering Action Group [seeActiveMagento2ForFirstOption] StorefrontAssertActiveProductImageActionGroup");
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento2']"); // stepKey: seeActiveImageDefaultSeeActiveMagento2ForFirstOption
		$I->comment("Exiting Action Group [seeActiveMagento2ForFirstOption] StorefrontAssertActiveProductImageActionGroup");
		$I->comment("Select second option");
		$I->comment("Entering Action Group [selectSecondOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectSecondOptionValue
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectSecondOptionValue
		$I->comment("Exiting Action Group [selectSecondOptionValue] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Check fotorama thumbnail images (second option selected)");
		$I->comment("Entering Action Group [seeMagento3ForSecondOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='magento3']"); // stepKey: seeActiveImageDefaultSeeMagento3ForSecondOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeMagento3ForSecondOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeMagento3ForSecondOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Entering Action Group [seeTestImageAdobeForSecondOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->seeElement(".fotorama__nav__shaft img[src*='adobe-base']"); // stepKey: seeActiveImageDefaultSeeTestImageAdobeForSecondOption
		$I->waitForPageLoad(30); // stepKey: seeActiveImageDefaultSeeTestImageAdobeForSecondOptionWaitForPageLoad
		$I->comment("Exiting Action Group [seeTestImageAdobeForSecondOption] StorefrontAssertFotoramaImageAvailabilityActionGroup");
		$I->comment("Check active fotorama thumbnail image (second option selected)");
		$I->comment("Entering Action Group [seeActiveTestImageNewForSecondOption] StorefrontAssertActiveProductImageActionGroup");
		$I->seeElement(".product.media div[data-active=true] > img[src*='magento-again']"); // stepKey: seeActiveImageDefaultSeeActiveTestImageNewForSecondOption
		$I->comment("Exiting Action Group [seeActiveTestImageNewForSecondOption] StorefrontAssertActiveProductImageActionGroup");
	}
}
