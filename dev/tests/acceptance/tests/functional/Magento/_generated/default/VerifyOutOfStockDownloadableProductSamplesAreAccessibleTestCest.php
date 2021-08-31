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
 * @Title("MC-35639: Samples of Downloadable Products are accessible, if product is out of stock")
 * @Description("Samples of Downloadable Products are accessible, if product is out of stock<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/VerifyOutOfStockDownloadableProductSamplesAreAccessibleTest.xml<br>")
 * @TestCaseId("MC-35639")
 * @group downloadable
 * @group catalog
 */
class VerifyOutOfStockDownloadableProductSamplesAreAccessibleTestCest
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
		$I->comment("Enable show out of stock product");
		$enableShowOutOfStockProduct = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 1", 60); // stepKey: enableShowOutOfStockProduct
		$I->comment($enableShowOutOfStockProduct);
		$I->comment("Add downloadable domains");
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create downloadable product");
		$I->createEntity("createProduct", "hook", "DownloadableProductWithoutLinksOutOfStock", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Add downloadable link");
		$I->createEntity("addDownloadableLink", "hook", "downloadableLink1", ["createProduct"], []); // stepKey: addDownloadableLink
		$I->comment("Add downloadable sample");
		$I->createEntity("addDownloadableSample", "hook", "DownloadableSample", ["createProduct"], []); // stepKey: addDownloadableSample
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable show out of stock product");
		$enableShowOutOfStockProduct = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 0", 60); // stepKey: enableShowOutOfStockProduct
		$I->comment($enableShowOutOfStockProduct);
		$I->comment("Remove downloadable domains");
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteDownloadableProduct
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Downloadable"})
	 * @Stories({"Downloadable product"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyOutOfStockDownloadableProductSamplesAreAccessibleTest(AcceptanceTester $I)
	{
		$I->comment("Open Downloadable product from precondition on Storefront");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Sample url is accessible");
		$I->comment("Entering Action Group [seeDownloadableSample] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeDownloadableSample
		$I->scrollTo("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('downloadableSampleUrl" . msq("DownloadableSample") . "'))]"); // stepKey: scrollToElementSeeDownloadableSample
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeDownloadableSampleWaitForPageLoad
		$I->seeElement("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('downloadableSampleUrl" . msq("DownloadableSample") . "'))]"); // stepKey: assertElementSeeDownloadableSample
		$I->waitForPageLoad(30); // stepKey: assertElementSeeDownloadableSampleWaitForPageLoad
		$I->comment("Exiting Action Group [seeDownloadableSample] AssertStorefrontSeeElementActionGroup");
		$I->click("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('downloadableSampleUrl" . msq("DownloadableSample") . "'))]"); // stepKey: clickDownloadableSample
		$I->waitForPageLoad(30); // stepKey: clickDownloadableSampleWaitForPageLoad
		$I->switchToNextTab(); // stepKey: switchToSampleTab
		$I->wait(2); // stepKey: waitToMakeSureThereWillBeNoRedirectToHomePage
		$I->seeInCurrentUrl("downloadable/download/sample/sample_id/"); // stepKey: amOnSampleDownloadPage
		$I->closeTab(); // stepKey: closeSampleTab
	}
}
