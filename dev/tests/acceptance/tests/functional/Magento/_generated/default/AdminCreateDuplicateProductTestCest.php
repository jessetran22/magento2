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
 * @Title("MC-14714: Create Duplicate Product With Existed Subcategory Name And UrlKey")
 * @Description("Login as admin and create duplicate Product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateDuplicateProductTest.xml<br>")
 * @TestCaseId("MC-14714")
 * @group mtf_migrated
 */
class AdminCreateDuplicateProductTestCest
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
		$I->createEntity("category", "hook", "SubCategory", [], []); // stepKey: category
		$I->createEntity("subCategory", "hook", "Two_nested_categories", ["category"], []); // stepKey: subCategory
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("subCategory", "hook"); // stepKey: deleteSubCategory
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateDuplicateProductTest(AcceptanceTester $I)
	{
		$I->comment("Go to new simple product page");
		$I->comment("Entering Action Group [goToCreateProductPage] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexGoToCreateProductPage
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownGoToCreateProductPageWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductGoToCreateProductPage
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadGoToCreateProductPage
		$I->comment("Exiting Action Group [goToCreateProductPage] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Fill the main fields in the form");
		$I->comment("Entering Action Group [fillMainProductForm] FillMainProductFormByStringActionGroup");
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('subCategory', 'name', 'test')); // stepKey: fillProductNameFillMainProductForm
		$I->fillField(".admin__field[data-index=sku] input", "testsku" . msq("defaultSimpleProduct")); // stepKey: fillProductSkuFillMainProductForm
		$I->fillField(".admin__field[data-index=price] input", "560.00"); // stepKey: fillProductPriceFillMainProductForm
		$I->fillField(".admin__field[data-index=qty] input", "25"); // stepKey: fillProductQtyFillMainProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillMainProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillMainProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillMainProductForm
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillMainProductForm
		$I->comment("Exiting Action Group [fillMainProductForm] FillMainProductFormByStringActionGroup");
		$I->comment("Select the category that we created in the before block");
		$I->comment("Entering Action Group [setCategory] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('category', 'name', 'test')]); // stepKey: searchAndSelectCategorySetCategory
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategorySetCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [setCategory] SetCategoryByNameActionGroup");
		$I->comment("Set the url key to match the subcategory created in the before block");
		$I->comment("Entering Action Group [fillUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->conditionalClick("div[data-index='search-engine-optimization']", "input[name='product[url_key]']", false); // stepKey: openSeoSectionFillUrlKey
		$I->fillField("input[name='product[url_key]']", $I->retrieveEntityField('subCategory', 'custom_attributes[url_key]', 'test')); // stepKey: fillUrlKeyFillUrlKey
		$I->comment("Exiting Action Group [fillUrlKey] SetProductUrlKeyByStringActionGroup");
		$I->comment("Save the product and expect to see an error message");
		$I->comment("Entering Action Group [tryToSaveProduct] SaveProductFormNoSuccessCheckActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductTryToSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonTryToSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonTryToSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductTryToSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductTryToSaveProductWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageTryToSaveProduct
		$I->comment("Exiting Action Group [tryToSaveProduct] SaveProductFormNoSuccessCheckActionGroup");
		$I->see("The value specified in the URL Key field would generate a URL that already exists.", "#messages"); // stepKey: seeErrorMessage
	}
}
