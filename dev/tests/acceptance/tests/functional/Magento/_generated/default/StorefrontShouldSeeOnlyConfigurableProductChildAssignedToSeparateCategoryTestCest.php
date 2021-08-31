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
 * @Title("MC-25651: It should be possible to only view the child product of a configurable product")
 * @Description("Create configurable product, add to category such that only child variation is visible in category<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontShouldSeeOnlyConfigurableProductChildAssignedToSeparateCategoryTest.xml<br>")
 * @TestCaseId("MC-25651")
 * @group configurable_product
 * @group catalog
 */
class StorefrontShouldSeeOnlyConfigurableProductChildAssignedToSeparateCategoryTestCest
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
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("secondCategory", "hook", "_defaultCategory", [], []); // stepKey: secondCategory
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the first option of the attribute we created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Get the second option of the attribute we created");
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create the configurable product and add it to the category");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create a simple product and give it the attribute with the first option");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->comment("Create a simple product and give it the attribute with the second option");
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Add the second simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Entering Action Group [loginToAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdmin
		$I->comment("Exiting Action Group [loginToAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteApiCategory
		$I->deleteEntity("secondCategory", "hook"); // stepKey: deleteSecondCategory
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"View products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontShouldSeeOnlyConfigurableProductChildAssignedToSeparateCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Go to the product page for the first product");
		$I->comment("Entering Action Group [openConfigChildProduct1Page] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductOpenConfigChildProduct1Page
		$I->comment("Exiting Action Group [openConfigChildProduct1Page] AdminProductPageOpenByIdActionGroup");
		$I->comment("Edit the visibility the first simple product");
		$I->selectOption("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: selectVisibilityCatalogSearch
		$I->comment("Add to category");
		$I->comment("Entering Action Group [addProductToCategoryAndSaveProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAddProductToCategoryAndSaveProduct
		$I->waitForPageLoad(30); // stepKey: openDropDownAddProductToCategoryAndSaveProductWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('secondCategory', 'name', 'test') . "')]"); // stepKey: selectCategoryAddProductToCategoryAndSaveProduct
		$I->waitForPageLoad(30); // stepKey: selectCategoryAddProductToCategoryAndSaveProductWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAddProductToCategoryAndSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAddProductToCategoryAndSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAddProductToCategoryAndSaveProduct
		$I->click("#save-button"); // stepKey: clickSaveAddProductToCategoryAndSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveAddProductToCategoryAndSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductAddProductToCategoryAndSaveProduct
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageAddProductToCategoryAndSaveProduct
		$I->comment("Exiting Action Group [addProductToCategoryAndSaveProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Go to storefront to view child product");
		$I->comment("Entering Action Group [goToSecondCategoryStorefront] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('secondCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageGoToSecondCategoryStorefront
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoToSecondCategoryStorefront
		$I->comment("Exiting Action Group [goToSecondCategoryStorefront] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [seeChildProductInCategory] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test') . "')]", 30); // stepKey: waitForProductSeeChildProductInCategory
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test') . "')]"); // stepKey: assertProductNameSeeChildProductInCategory
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceSeeChildProductInCategory
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductSeeChildProductInCategory
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartSeeChildProductInCategory
		$I->comment("Exiting Action Group [seeChildProductInCategory] StorefrontCheckCategorySimpleProductActionGroup");
		$I->comment("Entering Action Group [dontSeeOtherChildProduct] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->dontSee("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct2', 'name', 'test') . "')]"); // stepKey: dontSeeCorrectProductsOnStorefrontDontSeeOtherChildProduct
		$I->comment("Exiting Action Group [dontSeeOtherChildProduct] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->comment("Entering Action Group [dontSeeParentProduct] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->dontSee("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: dontSeeCorrectProductsOnStorefrontDontSeeParentProduct
		$I->comment("Exiting Action Group [dontSeeParentProduct] StorefrontCheckProductIsMissingInCategoryProductsPageActionGroup");
		$I->comment("Entering Action Group [openConfigChildProductFromCategoryPage] StorefrontOpenProductFromCategoryPageActionGroup");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test') . "')]"); // stepKey: openProductPageOpenConfigChildProductFromCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenConfigChildProductFromCategoryPage
		$I->comment("Exiting Action Group [openConfigChildProductFromCategoryPage] StorefrontOpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [checkStorefrontConfigChildProductPage] AssertStorefrontProductDetailPageNameAndUrlActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createConfigChildProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlCheckStorefrontConfigChildProductPage
		$I->seeInTitle($I->retrieveEntityField('createConfigChildProduct1', 'name', 'test')); // stepKey: assertProductNameTitleCheckStorefrontConfigChildProductPage
		$I->see($I->retrieveEntityField('createConfigChildProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameCheckStorefrontConfigChildProductPage
		$I->comment("Exiting Action Group [checkStorefrontConfigChildProductPage] AssertStorefrontProductDetailPageNameAndUrlActionGroup");
	}
}
