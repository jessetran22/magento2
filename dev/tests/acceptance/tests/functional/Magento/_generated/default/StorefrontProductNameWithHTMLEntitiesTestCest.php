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
 * @Title("MAGETWO-93794: :Proudct with html special characters in name")
 * @Description("Product with html entities in the name should appear correctly on the PDP breadcrumbs on storefront<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontProductNameWithDoubleQuoteTest/StorefrontProductNameWithHTMLEntitiesTest.xml<br>")
 * @group product
 * @TestCaseId("MAGETWO-93794")
 */
class StorefrontProductNameWithHTMLEntitiesTestCest
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
		$I->createEntity("createCategoryOne", "hook", "_defaultCategory", [], []); // stepKey: createCategoryOne
		$I->createEntity("productOne", "hook", "productWithHTMLEntityOne", ["createCategoryOne"], []); // stepKey: productOne
		$I->createEntity("productTwo", "hook", "productWithHTMLEntityTwo", ["createCategoryOne"], []); // stepKey: productTwo
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("productOne", "hook"); // stepKey: deleteProductOne
		$I->deleteEntity("productTwo", "hook"); // stepKey: deleteProductTwo
		$I->deleteEntity("createCategoryOne", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductNameWithHTMLEntitiesTest(AcceptanceTester $I)
	{
		$I->comment("Run re-index task");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Check product in category listing");
		$I->comment("Entering Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategoryOne', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeCorrectNameProd1CategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'SimpleOne™Product" . msq("productWithHTMLEntityOne") . "')]", 30); // stepKey: assertProductNameSeeCorrectNameProd1CategoryPage
		$I->comment("Exiting Action Group [seeCorrectNameProd1CategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [seeCorrectNameProd2CategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), 'SimpleTwo霁产品<カネボウPro" . msq("productWithHTMLEntityTwo") . "')]", 30); // stepKey: assertProductNameSeeCorrectNameProd2CategoryPage
		$I->comment("Exiting Action Group [seeCorrectNameProd2CategoryPage] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Open product display page");
		$I->comment("Entering Action Group [clickProductToGoProductPage] StorefrontOpenProductFromCategoryPageActionGroup");
		$I->click("//a[@class='product-item-link'][contains(text(), 'SimpleOne™Product" . msq("productWithHTMLEntityOne") . "')]"); // stepKey: openProductPageClickProductToGoProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickProductToGoProductPage
		$I->comment("Exiting Action Group [clickProductToGoProductPage] StorefrontOpenProductFromCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeCorrectName] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see("SimpleOne™Product" . msq("productWithHTMLEntityOne"), ".base"); // stepKey: seeProductNameSeeCorrectName
		$I->comment("Exiting Action Group [seeCorrectName] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeCorrectSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("SimpleOne™Product" . msq("productWithHTMLEntityOne"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeCorrectSku
		$I->comment("Exiting Action Group [seeCorrectSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [seeCorrectPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("50.00", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceSeeCorrectPrice
		$I->comment("Exiting Action Group [seeCorrectPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Veriy the breadcrumbs on Product Display page");
		$I->comment("Entering Action Group [seeHomePageInBreadcrumbs1] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->see("Home", ".items"); // stepKey: seeBreadcrumbsOnPageSeeHomePageInBreadcrumbs1
		$I->comment("Exiting Action Group [seeHomePageInBreadcrumbs1] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->comment("Entering Action Group [seeCorrectBreadCrumbCategory] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->see($I->retrieveEntityField('createCategoryOne', 'name', 'test'), ".items"); // stepKey: seeBreadcrumbsOnPageSeeCorrectBreadCrumbCategory
		$I->comment("Exiting Action Group [seeCorrectBreadCrumbCategory] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->comment("Entering Action Group [seeCorrectBreadCrumbProduct] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->see($I->retrieveEntityField('productOne', 'name', 'test'), ".items"); // stepKey: seeBreadcrumbsOnPageSeeCorrectBreadCrumbProduct
		$I->comment("Exiting Action Group [seeCorrectBreadCrumbProduct] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->comment("Entering Action Group [goBackToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategoryOne', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageGoBackToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoBackToCategoryPage
		$I->comment("Exiting Action Group [goBackToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Open product display page");
		$I->comment("Entering Action Group [clickProductToGoSecondProductPage] StorefrontOpenProductFromCategoryPageActionGroup");
		$I->click("//a[@class='product-item-link'][contains(text(), 'SimpleTwo霁产品<カネボウPro" . msq("productWithHTMLEntityTwo") . "')]"); // stepKey: openProductPageClickProductToGoSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickProductToGoSecondProductPage
		$I->comment("Exiting Action Group [clickProductToGoSecondProductPage] StorefrontOpenProductFromCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Verify the breadcrumbs on Product Display page");
		$I->comment("Entering Action Group [seeHomePageInBreadcrumbs2] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->see("Home", ".items"); // stepKey: seeBreadcrumbsOnPageSeeHomePageInBreadcrumbs2
		$I->comment("Exiting Action Group [seeHomePageInBreadcrumbs2] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->comment("Entering Action Group [seeCorrectBreadCrumbCategory2] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->see($I->retrieveEntityField('createCategoryOne', 'name', 'test'), ".items"); // stepKey: seeBreadcrumbsOnPageSeeCorrectBreadCrumbCategory2
		$I->comment("Exiting Action Group [seeCorrectBreadCrumbCategory2] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->comment("Entering Action Group [seeCorrectBreadCrumbProduct2] AssertStorefrontBreadcrubmsAreShownActionGroup");
		$I->see($I->retrieveEntityField('productTwo', 'name', 'test'), ".items"); // stepKey: seeBreadcrumbsOnPageSeeCorrectBreadCrumbProduct2
		$I->comment("Exiting Action Group [seeCorrectBreadCrumbProduct2] AssertStorefrontBreadcrubmsAreShownActionGroup");
	}
}
